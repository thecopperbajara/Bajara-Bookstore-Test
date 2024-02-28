<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'username'=> $this->username,
            'email'=> $this->email,
            'role_id'=> $this->role_id,
            'role'=> $this->roles->name,
            'image'=> $this->image,
            'created'=> $this->created_at
        ];
    }
}
