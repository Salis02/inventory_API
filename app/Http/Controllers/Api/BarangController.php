<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Resources\BarangResource;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;

class BarangController extends Controller
{
   public function index()
    {
        return BarangResource::collection(Barang::all());
    }

    public function store(StoreBarangRequest $request)
    {
        $barang = Barang::create($request->validated());
        return new BarangResource($barang);
    }

    public function show(Barang $barang)
    {
        return new BarangResource($barang);
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());
        return new BarangResource($barang);
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return response()->json(['message' => 'Barang berhasil dihapus.']);
    }
}
