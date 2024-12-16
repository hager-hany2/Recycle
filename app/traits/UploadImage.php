<?php

namespace App\Traits;

trait UploadImage
{
    /**
     * Handles image upload from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $fieldName The name of the field containing the image or URL
     * @param string $storagePath The directory to store the uploaded image
     * @return string|null The stored image path or the provided image URL
     */
    public function upload($request, $fieldName = 'image_url', $storagePath = 'images')
    {
        // Check if the field contains an uploaded file
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);

            // Validate and store the uploaded file
            $path = $file->store($storagePath, 'public');
            return $path; // Return the stored file path
        }

        // If it's not a file, check if it contains a URL
        if ($request->has($fieldName) && filter_var($request->input($fieldName), FILTER_VALIDATE_URL)) {
            return $request->input($fieldName); // Return the URL directly
        }

        // Return null if neither a file nor a valid URL is provided
        return null;
    }
}
