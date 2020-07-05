<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $token = $this->createToken('authToken')->accessToken;

        return [
            'user' => new UserResource($this),
            'access_token' => $token
        ];
    }
}
