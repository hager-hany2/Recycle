<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\Categories;
use App\Services\TranslationGoogle;
use Storage\app\public;


class CategoryControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use UploadImage;
    public function index(Request $request)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function


        // جلب جميع الفئات وترجمة الحقول المطلوبة مباشرةً
        $categories = Categories::all()->map(function ($category) use ($translator) {
            return [
                "category_id" => $category["category_id"],
                "category_name" => $translator->translate($category["category_name"]), // ترجمة اسم الفئة
                "category_description" => $translator->translate($category["category_description"]), // ترجمة وصف الفئة
                'image_url'=>$category['image_url'],//عرض الصورة

            ];
        });
        return response()->json($categories);//return json data
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFormRequest $request)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
//        dd($lang); //test lang
        $data=$request->validated();
//        dd($data);
        $existing_categories = categories::where('category_name', $request->category_name)->first();

        if ($existing_categories) {
            return response()->json([
                'error' => $translator->translate('already has been this category')],402);
        }
        //upload image
//        $imagePath = $this->upload($request);
//        $imagePath ?
//            response()->json(['image_url' => $imagePath], 200) :
//            response()->json([
//                'error' => $translator->translate('Must be valuable for that field image')],402);
        $imagePath = $this->upload($request);
        if (!$imagePath) {
            return response()->json(['error' => $translator->translate('Must be valuable for that field image')], 402);
        }
//             إنشاء الفئة وتخزينها
            $category = categories::create($request->only(['category_name', 'category_description','user_id','image_url'])); // التأكد من الحقول المطلوبة فقط
//             dd($category);
            // التحقق من نجاح عملية إنشاء الفئة
            if ($category) {
                return response()->json([
                    'message' => $translator->translate('Category saved successfully'),
//                    "category_name" => $translator->translate($category["category_name"]), // ترجمة اسم الفئة
//                    "category_description" => $translator->translate($category["category_description"]), // ترجمة وصف الفئة
                ], 201);
                }return response()->json([
                    'message'=>$translator->translate('failed save category')
            ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Display the specified resource.
        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }



        return response()->json($category);
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

    public function showProducts($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json([
                'error' => 'Category not found'], 404);
        }
        $products = $category->products;
        return response()->json($products);

    }
}
