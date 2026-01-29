<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\OrderItemAddon;
use App\Models\OrderStatusLog;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.addons' => 'nullable|array',

            'items.*.addons.photoSelected' => 'nullable|boolean',
            'items.*.addons.photoUrls' => 'nullable|array',
            'items.*.addons.photoUrls.*' => 'nullable|string|max:2048',

            'items.*.addons.glitterId' => 'nullable|integer|exists:addons,id',
            'items.*.addons.glitterColor' => [
                'nullable',
                'string',
                'max:20',
                'required_with:items.*.addons.glitterId',
                'regex:/^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/',
            ],

            'items.*.addons.ribbonText' => 'nullable|string|max:55',

            'items.*.addons.led' => 'nullable|boolean',


            'delivery_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $date = Carbon::parse($value)->startOfDay();

                    $min = now()->addDays(4)->startOfDay();
                    if ($date->lt($min)) {
                        $fail('Data livrării trebuie să fie peste 4 zile în viitor.');
                    }

                    if ($date->isWeekend()) {
                        $fail('Livrarea nu este disponibilă în weekend.');
                    }
                }
            ],

            'payment_method' => 'required|in:card',

            'coupon_code' => 'nullable|string|max:50|exists:coupons,code',

            'needs_invoice' => 'required|boolean',

            'invoice_details' => ['nullable', 'array', Rule::requiredIf(fn() => $request->boolean('needs_invoice'))],
            'invoice_details.company_name' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:255'],
            'invoice_details.cui' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:50'],
            'invoice_details.nr_reg_com' => ['nullable', 'string', 'max:50'],
            'invoice_details.contact' => [
                Rule::requiredIf(fn() => $request->boolean('needs_invoice')),
                'array',
            ],
            'invoice_details.contact.first_name' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:100'],
            'invoice_details.contact.last_name' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:100'],
            'invoice_details.contact.phone_number' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:20'],
            'invoice_details.contact.email' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'email', 'max:255'],
            'invoice_details.address' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'array'],
            'invoice_details.address.state' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:100'],
            'invoice_details.address.city' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:100'],
            'invoice_details.address.zipcode' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:100'],
            'invoice_details.address.address' => [Rule::requiredIf(fn() => $request->boolean('needs_invoice')), 'string', 'max:255'],

            'shipping' => ['required', 'array'],
            'shipping.email' => ['required', 'email', 'max:255'],
            'shipping.first_name' => ['required', 'string', 'max:255'],
            'shipping.last_name' => ['required', 'string', 'max:255'],
            'shipping.phone_number' => ['required', 'string', 'max:20'],
            'shipping.state' => ['required', 'string', 'max:45'],
            'shipping.city' => ['required', 'string', 'max:45'],
            'shipping.zipcode' => ['required', 'string', 'max:20'],
            'shipping.address' => ['required', 'string', 'max:45'],
        ]);

        if (!$request->boolean('needs_invoice')) {
            $data['invoice_details'] = null;
        }

        $user = $request->user();

        return DB::transaction(function () use ($user, $data) {
            $orderTotal = 0;

            //order
            $order = Order::create([
                'total_price' => $orderTotal,
                'status' => 'pending',
                'created_by' => $user?->id,
                'updated_by' => null,
                'subtotal' => 0,
                'discount' => 0,
                'transport' => 0,
                'coupon_code' => null,
                'payment_method' => $data['payment_method'],
                'delivery_date' => $data['delivery_date'],
            ]);

            $order_status_log = OrderStatusLog::create(['order_id' => $order->id, 'status' => 'pending', 'created_by' => $user?->id]);

            //order items + addons
            foreach ($data['items'] as $itemData) {
                $product = Product::with('categories')->findOrFail($itemData['product_id']);
                $quantity = (int)$itemData['quantity'];

                $unitPrice = (float)($product->discounted_price ?? $product->price ?? 0);

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => 0,
                ]);

                $addons = $itemData['addons'] ?? [];
                $addonsPerUnitTotal = $this->createAddonsForOrderItem($orderItem, $product, $addons);
                $lineTotal = ($unitPrice + $addonsPerUnitTotal) * $quantity;

                $orderItem->update(['total_price' => $lineTotal]);

                $orderTotal += $lineTotal;
            }

            //total price
            $subtotal = $orderTotal;

            //transport
            $shipping = $subtotal < 300 ? 25 : 0;

            //discount
            $discount = 0;
            $coupon = null;

            if (!empty($data['coupon_code'])) {
                $coupon = Coupon::where('code', $data['coupon_code'])->lockForUpdate()->first();

                if (!$coupon || !$coupon->isValidNow()) {
                    abort(422, 'Codul introdus nu este valid sau a expirat!');
                }

                $discount = $coupon->computeDiscount($subtotal);

                $coupon->increment('used_count');
            }

            //order details
            OrderDetail::create([
                'order_id' => $order->id,
                'first_name' => $data['shipping']['first_name'],
                'last_name' => $data['shipping']['last_name'],
                'email' => $data['shipping']['email'],
                'phone_number' => $data['shipping']['phone_number'],
                'state' => $data['shipping']['state'],
                'city' => $data['shipping']['city'],
                'zipcode' => $data['shipping']['zipcode'],
                'address' => $data['shipping']['address'],
                'country_code' => "RO",
                'invoice_details' => $data['invoice_details'] ?? null,
            ]);

            $finalTotal = max(0, $subtotal - $discount) + $shipping;

            $order->update(
                ['total_price' => $finalTotal, 'discount' => $discount, 'transport' => $shipping, 'subtotal' => $subtotal, 'payment_method' => $data['payment_method'], 'coupon_code' => $coupon?->code]
            );

            //order number
            $year = now()->year;
            $prefix = 'SS';
            $number = str_pad($order->id, 4, '0', STR_PAD_LEFT);

            $order_number = "{$prefix}-{$year}-{$number}";

            $order->update(['order_number' => $order_number]);

            return response()->json([
                'message' => 'Comanda a fost creată cu succes.',
                'order_id' => $order->id,
                'order_number' => $order_number,
            ], 201);
        });
    }

    protected function createAddonsForOrderItem(OrderItem $orderItem, Product $product, array $addons): float
    {
        $addonsPerUnitTotal = 0;

        if (!empty($addons['glitterId'])) {
            $glitter = Addon::where('id', $addons['glitterId'])->where('is_active', true)->first();

            if ($glitter) {
                $this->ensureAddonAllowedForAnyCategory($glitter, $product);

                OrderItemAddon::create([
                    'order_item_id' => $orderItem->id,
                    'addon_id' => $glitter->id,
                    'type' => $glitter->type,
                    'label' => $glitter->name,
                    'value' => [
                        'key' => $glitter->sub_type ?? 'glitter',
                        'hex_code' => $addons['glitterColor'] ?? $glitter->hex_code,
                    ],
                    'price' => $glitter->price,
                ]);

                $addonsPerUnitTotal += (float)$glitter->price;
            }
        }

        if (!empty($addons['ribbonText']) && trim($addons['ribbonText']) !== '') {
            $ribbon = Addon::where('type', 'b_accessories')->where('sub_type', 'ribbon')->where('is_active', true)->first();

            if ($ribbon) {
                $this->ensureAddonAllowedForAnyCategory($ribbon, $product);

                OrderItemAddon::create([
                    'order_item_id' => $orderItem->id,
                    'addon_id' => $ribbon->id,
                    'type' => $ribbon->type,
                    'label' => $ribbon->name,
                    'value' => ['key' => $ribbon->sub_type ?? 'ribbon', 'text' => $addons['ribbonText']],
                    'price' => $ribbon->price,
                ]);

                $addonsPerUnitTotal += (float)$ribbon->price;
            }
        }

        if (!empty($addons['led']) && $addons['led'] === true) {
            $led = Addon::where('type', 'b_accessories')->where('sub_type', 'led')->where('is_active', true)->first();

            if ($led) {
                $this->ensureAddonAllowedForAnyCategory($led, $product);

                OrderItemAddon::create([
                    'order_item_id' => $orderItem->id,
                    'addon_id' => $led->id,
                    'type' => $led->type,
                    'label' => $led->name,
                    'value' => ['key' => $led->sub_type ?? 'led', 'enabled' => true],
                    'price' => $led->price,
                ]);

                $addonsPerUnitTotal += (float)$led->price;
            }
        }

        if (!empty($addons['photoSelected']) &&
            $addons['photoSelected'] === true && !empty($addons['photoUrls']) &&
            is_array($addons['photoUrls']) && count(array_filter($addons['photoUrls'])) > 0) {
            $photo = Addon::where('type', 'b_accessories')->where('sub_type', 'photo')->where('is_active', true)->first();

            if ($photo) {
                $this->ensureAddonAllowedForAnyCategory($photo, $product);

                $photoUrls = array_values(array_filter($addons['photoUrls'], fn($u) => is_string($u) && trim($u) !== ''));

                foreach ($photoUrls as $url) {
                    OrderItemAddon::create([
                        'order_item_id' => $orderItem->id,
                        'addon_id' => $photo->id,
                        'type' => $photo->type,
                        'label' => $photo->name,
                        'value' => ['key' => $photo->sub_type ?? 'photo', 'url' => $url],
                        'price' => $photo->price,
                    ]);

                    $addonsPerUnitTotal += (float)$photo->price;
                }
            }
        }


        return $addonsPerUnitTotal;
    }

    protected function ensureAddonAllowedForAnyCategory(
        Addon $addon,
        Product $product
    ) {
        $productTopParentIds = $this->getProductTopParentCategoryIds($product);

        if (empty($productTopParentIds)) {
            abort(422, 'Produsul nu are categorie selectată. Nu se pot valida addons.');
        }

        $addonTopParentIds = $this->getAddonTopParentCategoryIds($addon);

        if (empty($addonTopParentIds)) {
            abort(422, "Addon '{$addon->name}' nu are categorii asignate. selectată. Nu se pot valida addons.");
        }

        $allowed = !empty(array_intersect($addonTopParentIds, $productTopParentIds));

        if (!$allowed) {
            abort(422, "Addon '{$addon->name}' nu este disponibil pentru acest produs.");
        }
    }

    protected function getProductTopParentCategoryIds(Product $product): array
    {
        $categories = $product->relationLoaded('categories') ? $product->categories :
            $product->categories()->with('parent.parent.parent')->get();

        if ($categories->isEmpty()) {
            return [];
        }

        return $categories->map(fn($c) => $c->topParent()->id)->unique()->values()->all();
    }

    protected function getAddonTopParentCategoryIds(Addon $addon): array
    {
        $categories = $addon->relationLoaded('categories') ? $addon->categories : $addon->categories()->with('parent.parent.parent')->get();

        if ($categories->isEmpty()) {
            return [];
        }

        return $categories->map(fn($c) => $c->topParent()->id)->unique()->values()->all();
    }
}
