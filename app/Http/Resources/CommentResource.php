<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource->toArray();
        $data['created_at'] = Carbon::parse($this->created_at)->locale('id')->translatedFormat('d F Y H:i:s');
        $data['updated_at'] = Carbon::parse($this->updated_at)->locale('id')->translatedFormat('d F Y H:i:s');
        $data['user_name'] = $this->user->name;

        return $data;
    }
}
