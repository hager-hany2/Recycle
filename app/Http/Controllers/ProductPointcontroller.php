<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPointFormRequest;
use App\Models\productspoints;
use App\Services\TranslationGoogle;
use App\traits\upload_image;
use Illuminate\Http\Request;

class ProductPointcontroller extends Controller
{
    use upload_image;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //        //           تعيين اللغة المطلوبة والافتراضية "en" إذا لم تُحدّد
        //        //ونضع اللغة المطلوبة في header in postman
        //        $lang = $request->header('lang', 'en');
        //
        //        // تهيئة مترجم Google Translate
        //        $translator = new GoogleTranslate(); // هنا اقوم باانشاء class
        //        $translator->setTarget($lang);
        //تحسين الكود
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
        // جلب جميع الفئات وترجمة الحقول المطلوبة مباشرةً
        $product = productspoints::all()->map(function ($product) use ($translator) {
            return [
                "user_id" => $translator->translate($product["user_id"]), // ترجمة اسم الفئة
                "ProductsPoints_id" => $translator->translate($product["ProductsPoints_id"]), // ترجمة وصف الفئة
                "name" => $translator->translate($product["name"]),  // ترجمة اسم الفئة
                "point" => $translator->translate($product["point"]),  // ترجمة اسم الفئة
                "image_url" => $translator->translate($product["image_url"]), // ترجمة وصف الفئة


            ];
        });
        return response()->json($product);//return json data
    }


    // Get All Products Points

    public function getProductsPoints(Request $request)
    {
        try {
            $productspoints = productspoints::all();
            if ($productspoints->isEmpty()) {
                return response()->json(['error' => 'No products found'], 404);
            }

            return response()->json($productspoints, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductPointFormRequest $request)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
//        dd($lang); //test lang
        $data = $request->validated();
//        dd($data);
        $existing_product = productspoints::where('name', $request->name)->first();

        //upload image
        $imagePath = $this->upload($request);
        $imagePath ?
            response()->json(['image_url' => $imagePath], 200) :
            response()->json([
                'error' => $translator->translate('Must be valuable for that field image')], 402);
        // إنشاء الفئة وتخزينها
        $category = productspoints::create($request->only(['user_id', 'ProductsPoints_id', 'name', 'point', 'image_url'])); // التأكد من الحقول المطلوبة فقط

        // التحقق من نجاح عملية إنشاء الفئة
        if ($category) {
            return response()->json([
                'message' => $translator->translate('Product saved successfully'),
            ], 201);
        }
        return response()->json([
            'message' => $translator->translate('failed save product')
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $productspoints = productspoints::find($id);
        if ($productspoints) {
            return response()->json($productspoints);
        }
        return response()->json(['error' => 'Product not found'], 404);


        return response()->json($productspoints);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
