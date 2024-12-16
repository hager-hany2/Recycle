<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\products;
use App\Services\TranslationGoogle;
use App\Traits\UploadImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use UploadImage;

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
        $product = products::all()->map(function ($product) use ($translator) {
            return [
                "product_name" => $translator->translate($product["product_name"]), // ترجمة اسم الفئة
                "product_description" => $translator->translate($product["product_description"]), // ترجمة وصف الفئة
                "price_product" => $translator->translate($product["price_product"]),  // ترجمة اسم الفئة
                "point_product" => $translator->translate($product["point_product"]),  // ترجمة اسم الفئة
                "category_name" => $translator->translate($product["category_name"]), // ترجمة وصف الفئة
                "QuantityType" => $translator->translate($product["QuantityType"]), // ترجمة اسم الفئة
                'image_url' => $product['image_url'],//عرض الصورة

            ];
        });
        return response()->json($product);//return json data
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
//        dd($lang); //test lang
        $data = $request->validated();
//        dd($data);
        $existing_product = products::where('product_name', $request->product_name)->first();
//dd($existing_product);
        if ($existing_product) {
            return response()->json([
                'error' => $translator->translate('already has been this product')], 402);
        }
        //upload image
        $imagePath = $this->upload($request);
        $imagePath ?
            response()->json(['image_url' => $imagePath], 200) :
            response()->json([
                'error' => $translator->translate('Must be valuable for that field image')], 402);
        // إنشاء الفئة وتخزينها
//        dd($imagePath);
        $category = products::create($request->only(['product_name', 'product_description', 'price_product', 'point_product', 'category_name', 'image_url', 'QuantityType', 'category_id'])); // التأكد من الحقول المطلوبة فقط
//      dd($category);
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
        //
        $Product = products::find($id);

        if (!$Product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }




        return response()->json($Product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
