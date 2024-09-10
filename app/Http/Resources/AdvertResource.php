<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'main_image' => $this->images[0] ?? null,
        ];

        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            if (in_array('images', $fields)) {
                $response['images'] = $this->images;
            }
        }

        return $response;
    }
}
