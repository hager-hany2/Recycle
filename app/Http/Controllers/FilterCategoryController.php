<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\products;
use App\Services\TranslationGoogle;
use Illuminate\Http\Request;


class FilterCategoryController extends Controller
{
    public function filter_category($category_id,Request $request )
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function

//         dd($lang);
        // جلب المنتجات حسب الفئة
        $products = products::where("category_id", $category_id)->get();


        // ترجمة الرسالة الرئيسية
        $message = $translator->translate('Success! Products displayed.');

        // ترجمة المنتجات باستخدام map
        $translatedProducts = $products->map(function ($product) use ($translator) {
            return [
                "product_name" => $translator->translate($product["product_name"]), // ترجمة اسم المنتج
                "product_description" => $translator->translate($product["product_description"]), // ترجمة وصف المنتج
                "price_product" => $product["price_product"], // السعر لا يتم ترجمته لأنه رقم
                "point_product" => $product["point_product"], // النقاط لا يتم ترجمتها
                "category_name" => $translator->translate($product["category_name"]), // ترجمة اسم الفئة
                "image_url_product" => $product["image_url_product"], // لا يتم ترجمة الـ URL
                "QuantityType" => $translator->translate($product["QuantityType"]), // ترجمة نوع الكمية
            ];
        });

        // إرجاع الاستجابة مع الرسالة المترجمة والمنتجات المترجمة
        return response([
            'message' => $message,
            'data' => $translatedProducts
        ], 200);
    }


}
