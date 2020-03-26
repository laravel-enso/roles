<?php

namespace LaravelEnso\Roles\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'displayName' => $this->display_name,
            'description' => $this->description,
        ];
    }
}
