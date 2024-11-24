<?php

namespace App\traits;
use Illuminate\Support\Facades\Storage;

trait upload_image
{

    public function upload($request)
    {
        // تحقق من وجود الرابط
        if ($request->has('image_url')) {
            $imageUrl = $request->input('image_url'); // استلام الرابط من الـ request
            // يمكنك تخزين الرابط في قاعدة البيانات أو القيام بأي عملية أخرى
            return response()->json(['image_url' => $imageUrl], 200);
        }
    }

}
