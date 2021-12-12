<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index($id)
    {
        $user  = User::where('id', $id)->get();
        return response()->json([
            'success' => 1,
            'message' => 'Data sukses',
            'user' => $user
        ]);
    }
    public function Login(Request $request){

        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->error('Login gagal');
        }
        
        $validpassowrd = Hash::check($password, $user->password);
        
        if (!$validpassowrd) {
            return $this->error('Login gagal');
        }
        
        $user->update([
            'fcm' => $request->fcm
        ]);
        return response()->json([
            'success' => 1,
            'data' => $user,
            'message' => "Login sukses"
        ]);
        
    }

    public function register(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }
        
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = Hash::make($request->input('password'));

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'user_id' => 'user'
        ]);

        return response()->json([
            'success' => 1,
            'data' => $user,
            'message' => "Login sukses"
        ]);
    }

    public function error($pesan)
    {
        return response()->json([
            'success' => 0,
            'message' => $pesan
        ]);
    }
}