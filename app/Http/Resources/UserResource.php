<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id, 
            'name' => $this->name, 
            'role' => $this->role,
            'email' => $this->email, 
            'created at' => $this->created_at, 
            'updated_at' => $this->updated_at,
        ];
    }
}
