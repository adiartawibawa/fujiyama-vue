<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'users' =>  $this->users,
            'permissions' => $this->permissions->pluck('name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
