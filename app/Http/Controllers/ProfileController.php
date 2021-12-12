<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaksi;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id =  Auth::user()->id;
        $register = User::where('user_id', 'user')->count();
        $transaksi = Transaksi::where('user_id', $id)->count();
        return view('profile', compact('register','transaksi'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->_validasi($request);
        User::create(array_merge($request->all()));
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = array(
            'name' => $request->get('name'), 
            'email' => $request->get('email'), 
            'phone' => $request->get('phone'),
            'alamat' => $request->get('alamat'), 
            'nama_toko' => $request->get('nama_toko')
        );
        User::where('id', $id)->update($data);
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}