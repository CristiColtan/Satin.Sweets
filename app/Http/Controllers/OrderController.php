<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function show(Request $request, Order $order)
    {
        $user = $request->user();

        if ((int)$order->created_by !== (int)$user->id) {
            return abort(404);
        }

        $order->load(['details', 'items', 'items.product', 'items.product.media', 'items.addons', 'lastPayment', 'statusLogs']);

        return response()->json($order);
    }

    public function storeOne(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);

        $file = $request->file('photo');

        $folder = $this->baseFolder($request);

        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $relativePath = $file->storeAs($folder, $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::disk('public')->url($relativePath),
            'path' => $relativePath,
        ]);
    }

    private function baseFolder(Request $request): string
    {
        $userId = optional($request->user())->id;

        if ($userId) {
            return 'order-uploads/tmp/user-' . $userId . '/' . now()->format('Y/m/d');
        }

        $token = $request->input('upload_token'); // trimis din frontend
        if (!$token) {
            $token = (string)Str::uuid();
        }

        return 'order-uploads/tmp/guest-' . $token . '/' . now()->format('Y/m/d');
    }

}
