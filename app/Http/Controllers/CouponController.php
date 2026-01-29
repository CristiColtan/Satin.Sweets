<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'required|int|min:0'
        ]);

        $code = strtoupper(trim($data['code']));
        $subtotal = (int)$data['subtotal'];

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValidNow()) {
            return response()->json([
                'success' => false,
                'message' => 'Codul introdus nu este valid sau a expirat!'
            ], 422);
        }

        if ($subtotal < $coupon->min_subtotal) {
            return response()->json([
                'success' => false,
                'message' => "Pentru codul {$coupon->code} valoarea produselor trebuie să depășească {$coupon->min_subtotal} RON."
            ], 422);
        }

        $discount = $coupon->computeDiscount($subtotal);

        return response()->json([
            'success' => true,
            'message' => "Codul {$coupon->code} a fost aplicat.",
            'couponCode' => $coupon->code,
            'couponDiscount' => $discount,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);
    }
}
