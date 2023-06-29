<?php

namespace App\Http\Resources\Survey;

use Illuminate\Http\Resources\Json\JsonResource;

class sellerOrganizationMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "options" => [
                "uuid" => $this->id,
                "text" => $this->firstName . ' ' . $this->lastName
            ]
        ];
    }
}
