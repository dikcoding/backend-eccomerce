<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'category_id' => $this->category_id,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'brand'       => $this->brand,
            'berat'       => $this->berat,
            'satuan'      => $this->satuan,
            'deskripsi'   => $this->deskripsi,
            'foto'        => $this->foto,
            'user_id'     => $this->user_id,
            'created_at'  => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'  => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
