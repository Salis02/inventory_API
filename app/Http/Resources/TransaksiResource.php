<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'barang' => [
                'id' => $this->barang->id,
                'nama' => $this->barang->nama,
                'kode' => $this->barang->kode,
                'stok' => $this->barang->stok,
            ],
            'tanggal' => $this->tanggal,
            'tipe_transaksi' => $this->tipe_transaksi,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'jumlah' => $this->jumlah,

        ];
    }
}
