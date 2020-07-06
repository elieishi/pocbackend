<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CreateListingRequest;
use App\Http\Resources\ListingResource;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ListingsController extends Controller
{
    public function store(CreateListingRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = SlugService::createSlug(Category::class, 'slug', $data['title']);

        $listing = $request->user()->listings()->create($data);
        $category = Category::whereSlug($data['category'])->first();

        if($category) {
            $listing->category()->associate($category);
            $listing->save();
        }

        return response(new ListingResource($listing), 201);

    }
}
