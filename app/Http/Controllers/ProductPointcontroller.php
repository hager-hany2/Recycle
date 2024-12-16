<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPointFormRequest;
use App\Models\ProductsPoints;
use App\Services\TranslationGoogle;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductPointController extends Controller
{
    use UploadImage;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $translator = new TranslationGoogle($lang);

            $products = ProductsPoints::all()->map(function ($product) use ($translator) {
                return [
                    "user_id" => $translator->translate($product["user_id"]),
                    "id" => $product["id"],
                    "name" => $translator->translate($product["name"]),
                    "point" => $translator->translate($product["point"]),
                    "image_url" => $product["image_url"], // No need to translate URLs
                ];
            });

            return response()->json($products, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching product points: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * Get All Products Points.
     */
    public function getProductsPoints(Request $request)
    {
        try {
            $productspoints = ProductsPoints::all();

            if ($productspoints->isEmpty()) {
                return response()->json(['error' => 'No products found'], 404);
            }

            return response()->json($productspoints, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching all product points: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductPointFormRequest $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $translator = new TranslationGoogle($lang);
            $data = $request->validated();

            // Check if product with the same name exists
            $existingProduct = ProductsPoints::where('name', $data['name'])->first();
            if ($existingProduct) {
                return response()->json(['error' => $translator->translate('Product with the same name already exists')], 409);
            }

            // Upload image if present
            $imagePath = $this->upload($request);
            if (!$imagePath) {
                return response()->json([
                    'error' => $translator->translate('Must provide a valid image for the field')
                ], 422);
            }

            // Create product point
            $productPoint = ProductsPoints::create([
                'user_id' => $data['user_id'],
                'id' => $data['ProductsPoints_id'],
                'name' => $data['name'],
                'point' => $data['point'],
                'image_url' => $imagePath,
            ]);

            return response()->json([
                'message' => $translator->translate('Product saved successfully'),
                'product' => $productPoint
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error storing product point: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $productPoint = ProductsPoints::find($id);

            if (!$productPoint) {
                return response()->json(['error' => 'ProductPoint not found'], 404);
            }

            return response()->json($productPoint, 200);
        } catch (\Exception $e) {
            Log::error('Error showing product point: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $productPoint = ProductsPoints::find($id);
            if (!$productPoint) {
                return response()->json(['error' => 'ProductPoint not found'], 404);
            }

            $data = $request->validate([
                'name' => 'nullable|string|max:255',
                'point' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $this->upload($request);
                $productPoint->image_url = $imagePath;
            }

            $productPoint->update($data);

            return response()->json([
                'message' => 'Product point updated successfully',
                'product' => $productPoint
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating product point: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $productPoint = ProductsPoints::find($id);
            if (!$productPoint) {
                return response()->json(['error' => 'ProductPoint not found'], 404);
            }

            $productPoint->delete();
            return response()->json([
                'message' => 'Product point deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting product point: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}
