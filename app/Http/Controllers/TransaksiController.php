<?php

namespace App\Http\Controllers;

use App\Transaksi;
use App\User;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\TransaksiDetail;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
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
        
        $transaksiMenunggu = Transaksi::with('user')->where('user_id', $id)->whereStatus("MENUNGGU")->orderBy('id', 'desc')->get();
        $transaksiSelesai = Transaksi::where('status','NOT LIKE',"%MENUNGGU%")->orderBy('id', 'desc')->get();
        return view('transaksi', compact('transaksiMenunggu','transaksiSelesai', 'register', 'transaksi'));
    }

    public function batal($id)
    {
        $transaksi  = Transaksi::where('id', $id)->first();
        $this->pushNotif("Transaksi dibatalkan", "Transaksi produk ".$transaksi->details[0]->produk->name.", telah dibatalkan",  $transaksi->user->fcm);
        $transaksi->update([
                'status' => "BATAL"
            ]);
        return redirect()->back();
    }

    public function proses($id)
    {
        $transaksi  = Transaksi::with(['details.produk'])->where('id', $id)->first();
        $this->pushNotif("Transaksi sedang diproses", "Transaksi produk ".$transaksi->details[0]->produk->name.", telah diproses",  $transaksi->user->fcm);
        $transaksi->update([
                'status' => "PROSES"
            ]);
        return redirect()->back();
    }

    public function kirim($id)
    {
        $transaksi  = Transaksi::with(['details.produk'])->where('id', $id)->first();
        $this->pushNotif("Proses Pengiriman", "Transaksi produk ".$transaksi->details[0]->produk->name.", sedang dalam pengiriman",  $transaksi->user->fcm);
        $transaksi->update([
                'status' => "DIKIRIM"
            ]);
        return redirect()->back();
    }

    public function selesai($id)
    {
        $transaksi  = Transaksi::with(['details.produk'])->where('id', $id)->first();
        $this->pushNotif("Transaksi selesai", "Transaksi produk ".$transaksi->details[0]->produk->name.", telah diterima",  $transaksi->user->fcm);
        $transaksi->update([
                'status' => "SELESAI"
            ]);
        return redirect()->back();
    }

    
    public function detail($id)
    {
        $transaksi  = Transaksi::find($id);
        $detail_transaksi = TransaksiDetail::with('produk')->where('transaksi_id', $id)->first();
        return view('detailtransfer', compact('transaksi','detail_transaksi'));
    }

    
    public function pushNotif($title, $message, $mfcm) {

        $mData = [
            'title' => $title,
            'body' => $message
        ];

        $fcm[] = $mfcm;

        $payload = [
            'registration_ids' => $fcm,
            'notification' => $mData
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json",
                "Authorization: key=AAAAsAziE3k:APA91bHNQBXv6ldDQGr8a5k7RJWU5sMlJmFBkttTpOK6dmETvEbVeFXWEhKlhTgqgLs7KdiXOt-2GbfLHvkUldZihu009ZKZx0_O7cadJuL2WusR9Y7VAE5mddc5vj0e34Sh6eRm7hPW"
            ),
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = [
            'success' => 1,
            'message' => "Push notif success",
            'data' => $mData,
            'firebase_response' => json_decode($response)
        ];
        return $data;
    }


}