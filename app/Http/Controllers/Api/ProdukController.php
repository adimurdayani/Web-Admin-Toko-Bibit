<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $produk  = Produk::all();
        return response()->json([
            'success' => 1,
            'message' => 'Data sukses',
            'produk' => $produk
        ]);
    }
    public function get_id($id)
    {
        Produk::where('user_id', $id)->increment('views');
        
        $produk  = Produk::where('kategori_id', $id)->limit(4)->get();
        return response()->json([
            'success' => 1,
            'message' => 'Data sukses',
            'produk' => $produk
        ]);
    }

    public function get_id_all($id)
    {        
        $produk  = Produk::where('kategori_id', $id)->get();
        return response()->json([
            'success' => 1,
            'message' => 'Data sukses',
            'produk' => $produk
        ]);
    }
}