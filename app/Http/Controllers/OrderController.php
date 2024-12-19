<?php

namespace App\Http\Controllers;

use App\Models\Orderpoints;
use App\Models\products;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductsPoints;
use App\Services\TranslationGoogle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function placeOrder(Request $request): JsonResponse
    {
        $translator = new TranslationGoogle($request->header('lang', 'en'));
        $validated = $request->validate([
            'cart' => 'required|array',
            'paymentMethod' => 'required|string',
            'totalPrice' => 'required|numeric',
            'totalPoints' => 'required|integer',
            'address' => 'required|string',
            'number' => 'required|string'
        ]);

        return DB::transaction(function () use ($validated, $translator) {
            $cart = $validated['cart'];
            $user = Auth::user();

            if (!$this->hasSufficientBalance($user, $cart)) {
                return response()->json([
                    'message' => $translator->translate('Insufficient points balance for this transaction.')
                ], 422);
            }

            foreach ($cart as $item) {
                $product = $item['product'];
                $productId = $this->extractId($product['product_id']);
                $totalAmount = $item['totalAmount'];

                if ($item['product_type'] === 'points') {
                    $product = ProductsPoints::find($productId);
                    if ($product) {
                        $user->point -= $totalAmount * $product->point_product;
                        Orderpoints::create([
                            'ProductsPoints_id' => $productId,
                            'user_id' => $user->id,
                            'address' => $validated['address'],
                            'phone' => $validated['number'],
                            'status' => 'pending',
                            'total_price' => $totalAmount * $product->point_product,
                            'quantity' => $totalAmount
                        ]);
                    }
                } else {

                    $product = products::find($productId);
                    if ($product) {
                        Order::create([
                            'product_id' => $productId,
                            'user_id' => $user->id,
                            'address' => $validated['address'],
                            'phone' => $validated['number'],
                            'status' => 'pending',
                            'total_price' => $totalAmount * $product->price_product,
                            'quantity' => $totalAmount
                        ]);

                        // add points for user
//                        $user->price
//                        $user->point
                    }
                }

            }

            $user->save(); // Update user points balance in database

            return response()->json([
                'message' => $translator->translate('Order placed successfully'),
                'details' => ['pointsProducts' => $cart]
            ], 201);
        });
    }

    protected function hasSufficientBalance($user, $cart)
    {
        $totalPointsNeeded = array_sum(array_map(function ($item) {
            if ($item['product_type'] === 'points') {
                return $item['totalAmount'] * $item['product']['point_product'];
            }
            return 0;
        }, $cart));

        return $user->point >= $totalPointsNeeded;
    }

    protected function extractId($identifier)
    {
        if (is_numeric($identifier)) {
            return $identifier; // Directly return if it's already a number
        }
        // Match the last digits in the string (e.g., "pointsid_1" -> "1")
        return preg_match('/\d+$/', $identifier, $matches) ? (int) $matches[0] : null;
    }
}
