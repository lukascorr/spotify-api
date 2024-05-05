<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource['name'],
            'released' => $this->resource['release_date'],
            'tracks' => $this->resource['total_tracks'],
            'cover' => $this->resource['images'][0]
        ];
    }
}
