<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderpoints;
use App\Models\products;
use App\Models\ProductsPoints;
use App\Services\TranslationGoogle;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Handles the placement of an order
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function placeOrder(Request $request): JsonResponse
    {
        $translator = new TranslationGoogle($request->header('lang', 'en'));

        // Validate incoming request
        $validated = $request->validate([
            'cart' => 'required|array',
            'paymentMethod' => 'required|string',
            'totalPrice' => 'required|numeric',
            'totalPoints' => 'required|integer',
            'address' => 'required|string',
            'number' => 'required|string'
        ]);

        try {
            return DB::transaction(function () use ($validated, $translator) {
                $cart = $validated['cart'];
                $user = Auth::user();

                // Store the user's original point balance
                $originalUserPoints = $user->point;

                // Track total points and price adjustments
                $totalPointsToAdd = 0;
                $totalPointsToDeduct = 0;
                $totalUserPrice = 0;

                /**
                 * **Step 1** - Process category products first
                 * Add points to user balance before processing points products
                 */
                foreach ($cart as $item) {
                    if ($item['product_type'] === 'category') {
                        $productId = $this->extractId($item['product']['product_id']);
                        $totalAmount = $item['totalAmount'];

                        $result = $this->processCategoryProduct($productId, $totalAmount, $validated);

                        $totalPointsToAdd += $result['pointsToAdd'];
                        $totalUserPrice += $result['priceToAdd'];
                    }
                }

                // ** Update user's balance to reflect points from category products **
                $user->update([
                    'point' => $user->point + $totalPointsToAdd,
                    'price' => $user->price + $totalUserPrice
                ]);

                // Refresh user instance to get updated point balance
                $user->refresh();

                /**
                 * **Step 2** - Process points-based products
                 * Deduct points from the user's balance
                 */
                if (!$this->hasSufficientBalance($user, $cart)) {
                    return response()->json([
                        'message' => $translator->translate('Insufficient points balance for this transaction.')
                    ], 422);
                }

                foreach ($cart as $item) {
                    if ($item['product_type'] === 'points') {
                        $productId = $this->extractId($item['product']['product_id']);
                        $totalAmount = $item['totalAmount'];

                        $result = $this->processPointsProduct($productId, $totalAmount, $validated);
                        $totalPointsToDeduct += abs($result['pointsToDeduct']);
                    }
                }

                // ** Calculate final points **
                $final_points = $originalUserPoints + $totalPointsToAdd - $totalPointsToDeduct;

                // ** Update user's final points balance once **
                $user->update([
                    'point' => $final_points
                ]);

                return response()->json([
                    'message' => $translator->translate('Order placed successfully'),
                    'details' => [
                        'pointsProducts' => $cart,
                        'totalPointsToAdd' => $totalPointsToAdd,
                        'totalPointsToDeduct' => $totalPointsToDeduct,
                        'totalUserPrice' => $totalUserPrice,
                        'final_points' => $final_points
                    ]
                ], 201);
            });

        } catch (\Exception $e) {
            Log::error("Error placing order: " . $e->getMessage());
            return response()->json([
                'message' => $translator->translate('Something went wrong, please try again later.')
            ], 500);
        }
    }

    protected function processCategoryProduct($productId, $totalAmount, $validated): array
    {
        $product = products::find($productId);

        if (!$product) {
            Log::error("Category product not found: ProductID={$productId}");
            return ['pointsToAdd' => 0, 'priceToAdd' => 0];
        }

        Order::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'address' => $validated['address'],
            'phone' => $validated['number'],
            'status' => 'pending',
            'total_price' => $totalAmount * $product->price_product,
            'quantity' => $totalAmount
        ]);

        $pointsToAdd = $totalAmount * $product->point_product;
        $priceToAdd = $totalAmount * $product->price_product;

        return ['pointsToAdd' => $pointsToAdd, 'priceToAdd' => $priceToAdd];
    }

    protected function processPointsProduct($productId, $totalAmount, $validated): array
    {
        $product = ProductsPoints::find($productId);

        if (!$product) {
            Log::error("Points product not found: ProductID={$productId}");
            return ['pointsToDeduct' => 0];
        }

        Orderpoints::create([
            'ProductsPoints_id' => $productId,
            'user_id' => Auth::id(),
            'address' => $validated['address'],
            'phone' => $validated['number'],
            'pickup_time' => Carbon::now()->addDays(3),
            'status' => 'pending',
            'total_price' => $totalAmount * $product->point,
            'quantity' => $totalAmount
        ]);

        $pointsToDeduct = $totalAmount * $product->point;

        return ['pointsToDeduct' => abs($pointsToDeduct)];
    }

    protected function hasSufficientBalance($user, $cart): bool
    {
        $totalPointsNeeded = array_sum(array_map(function ($item) {
            if ($item['product_type'] === 'points') {
                return $item['totalAmount'] * $item['product']['point_product'];
            }
            return 0;
        }, $cart));

        return $user->point >= $totalPointsNeeded;
    }

    protected function extractId($identifier): ?int
    {
        if (is_numeric($identifier)) {
            return (int) $identifier;
        }

        $id = preg_match('/\d+$/', $identifier, $matches) ? (int) $matches[0] : null;

        if (is_null($id)) {
            Log::error("Failed to extract ID from identifier: {$identifier}");
        }

        return $id;
    }
}
