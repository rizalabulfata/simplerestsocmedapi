<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource->toArray();
        $data['created_at'] = $this->resource->created_at->format('Y-m-d H:i:s');
        $data['updated_at'] = $this->resource->updated_at->format('Y-m-d H:i:s');

        return $data;
    }
}
