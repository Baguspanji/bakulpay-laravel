<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AdminController extends Controller
{

    public function index()
    {
        $admins = Admin::all();

        return response()->json($admins);
    }

    // public function Register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'username' => 'required',
    //         'number_phone' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'confirm_password' => 'required|same:password',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'succes' => false,
    //             'message' => 'something wrong',
    //             'data' => $validator->errors()
    //         ]);
    //     }

    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = User::create($input);


    //     $success['email'] = $user->email;
    //     $success['name'] = $user->name;

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'register successful',
    //         'data' => $success
    //     ]);
    // }

    // public function Daftar(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'username' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'confirm_password' => 'required|same:password',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'succes' => false,
    //             'message' => 'something wrong',
    //             'data' => $validator->errors()
    //         ]);
    //     }

    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = Admin::create($input);


    //     $success['email'] = $user->email;
    //     $success['name'] = $user->name;

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'register successful',
    //         'data' => $success
    //     ]);
    // }

    public function Daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'noHp' => 'required|numeric', // Add validation for 'noHp'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        // Ensure 'noHp' is added to the fillable property in the Admin model
        $user = Admin::create($input);

        $success['email'] = $user->email;
        $success['name'] = $user->name;
        $success['noHp'] = $user->noHp; // Include 'noHp' in the response

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => $success
        ]);
    }


    // public function login(Request $request)
    // {
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

    //         $user = User::where('email', $request->email)->first();

    //         $success['access_token'] = $user->createToken('auth_token')->plainTextToken;
    //         $success['token_type'] = 'Bearer';
    //         $success['name'] = $user->name;
    //         $success['user_id'] = $user->id;

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Login Berhasil',
    //             'data' => $success,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Cek kembali email dan password',
    //             'data' => null
    //         ]);
    //     }
    // }

    public function Login_GM(Request $request)
    {
        // Validasi input kosong
        if (!$request->email && !$request->name) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau name tidak boleh kosong',
                'data' => null
            ]);
        }

        // Inisialisasi variabel untuk user
        $admin = null;

        // Validasi berdasarkan email atau username
        if ($request->email && $request->name) {
            // Jika keduanya diberikan, pilih salah satu (misalnya, email)
            $admin = Admin::where('email', $request->email)->first();
        } elseif ($request->email) {
            $admin = Admin::where('email', $request->email)->first();
        } elseif ($request->name) {
            $admin = Admin::where('username', $request->name)->first();
        }

        // Jika user tidak ditemukan, kembalikan respons error
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Cek kembali email atau username',
                'data' => null
            ]);
        }

        // Jika login berhasil, buat access token dan kembalikan respons sukses
        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'name' => $admin->name,
                'user_id' => $admin->id,
            ],
        ]);
    }

    public function Masuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $admin = Admin::where('email', $request->email)
            ->first();

        // If no user is found or password doesn't match, return error response
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
                'data' => null
            ]);
        }

        // If login is successful, create access token and return success response
        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'name' => $admin->name,
                'user_id' => $admin->id,
            ],
        ]);
    }



    public function keluar(Request $request)
    {
        $admin = $request->admin();

        // Revoke the user's token
        $admin->tokens()->where('id', $admin->currentAccessToken()->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
