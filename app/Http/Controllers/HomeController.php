<?php

namespace App\Http\Controllers;

use App\KategoriModel;
use App\Produk;
use App\Transaksi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id =  Auth::user()->id;
        
        $produk = Produk::where('user_id', $id)->count();
        $produktotal = Produk::where('user_id', $id)->sum('views');

        $register = User::where('user_id', 'user')->count();
        $transaksi = Transaksi::where('user_id', $id)->count();

        $kategoriAll = KategoriModel::all();
        $produkAll = Produk::all();
        $kategori = [];
        $data = [];
        foreach ($kategoriAll as $get) {
            $kategori[] = $get->nama_kategori;
            $data[] = $produkAll->where('kategori_id', $get->id)->count();
        }

        return view('home', compact('produk','register','transaksi', 'produktotal', 'kategori', 'data'));
    }
}