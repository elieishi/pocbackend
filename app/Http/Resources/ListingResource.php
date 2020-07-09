<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'slug' => $this->slug,
            'currency' => $this->currency,
            'date_online'=> $this->date_online,
            'date_offline' => $this->date_offline,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => $this->category->slug
        ];
    }
}
