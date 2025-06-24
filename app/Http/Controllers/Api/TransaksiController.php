<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Resources\TransaksiResource;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransaksiResource::collection(Transaksi::with(['barang', 'user'])->latest()->get());
    }

    public function store(StoreTransaksiRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        return DB::transaction(function () use ($validated, $user) {
            $barang = Barang::lockForUpdate()->findOrFail($validated['barang_id']);
            $jumlah = $validated['jumlah'];

            if ($validated['tipe_transaksi'] === 'keluar' && $barang->stok - $jumlah <= 10) {
                return response()->json(['message' => 'Stok tidak mencukupi untuk transaksi keluar.'], 400);
            }

            // Update stok
            $barang->stok += ($validated['tipe_transaksi'] === 'masuk') ? $jumlah : -$jumlah;
            $barang->save();

            $transaksi = Transaksi::create([
                'barang_id' => $barang->id,
                'tanggal' => $validated['tanggal'],
                'tipe_transaksi' => $validated['tipe_transaksi'],
                'user_id' => $user->id,
                'jumlah' => $jumlah,
            ]);

            return new TransaksiResource($transaksi->load(['barang', 'user']));
        });
    }

    public function show(Transaksi $transaksi)
    {
        return new TransaksiResource($transaksi->load(['barang', 'user']));
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return response()->json(['message' => 'Transaksi dihapus.']);
    }
}
