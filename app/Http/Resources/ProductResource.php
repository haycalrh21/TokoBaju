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
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->convertCurrency($this->price),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    private function convertCurrency($priceInDollar)
    {
        // Logika konversi harga dari dolar ke Rupiah
        // Anda dapat menyesuaikan logika konversi sesuai kebutuhan
        $exchangeRate = 15000; // Gantilah dengan nilai tukar yang sesuai
        $priceInRupiah = $priceInDollar * $exchangeRate;

        return $priceInRupiah;
    }
}
