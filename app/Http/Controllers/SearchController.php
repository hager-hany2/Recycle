<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Services\TranslationGoogle;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
        // الحصول على قيمة الاسم من الـ query
        $name = $request->input('product_name');
        if (preg_match('/[\x{0600}-\x{06FF}]/u', $name)) {
            // إذا كان النص بالعربية، نقوم بترجمته إلى الإنجليزية
            $name = GoogleTranslate::trans($name, 'en', 'ar');
//            dd($name);
        }

//        dd($name);
        // تحديد الحقل الذي سيتم البحث فيه بناءً على اللغة
        $search_lang= ($lang === 'ar') ? 'ar' : 'en';
//        dd($search_lang);

        // إذا كان هناك قيمة في الاسم، نبحث في المنتجات
        if ($name) {
            $products = products::where('product_name', 'LIKE', '%' . $name . '%')->get();
//            dd($products);
        } else {
            // إذا لم يكن هناك اسم، نرجع جميع المنتجات
            $products = products::all();
//            dd($products);
        }
        $translatedProducts = $products->map(function ($product) use ($translator) {
            return [
                'product_name' => $translator->translate($product->product_name), // ترجمة اسم المنتج
                'product_description' => $translator->translate($product->product_description), // ترجمة وصف المنتج
                'price_product' => $product->price_product, // يمكن الإبقاء على السعر كما هو
                'point_product' => $product->point_product, // يمكن الإبقاء على النقاط كما هي
                'category_name' => $translator->translate($product->category_name), // ترجمة اسم الفئة
                'QuantityType' => $translator->translate($product->QuantityType), // ترجمة نوع الكمية
                'image_url_product' => $product->image_url_product, // عرض الصورة كما هي
            ];
        });
        return response()->json($translatedProducts);
    }
}
