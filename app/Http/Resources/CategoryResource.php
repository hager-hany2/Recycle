<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arr = [
            'category_id'=>$this->category_id,
            'category_name'=>$this->category_name,
            'category_description'=>$this->category_description,
            'image_url'=>$this->image_url,
        ];
        return $arr;
//        return parent::toArray($request);
    }
}
