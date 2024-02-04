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
use Illuminate\Support\Facades\URL;

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

    // public function Daftar(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'username' => 'required',
    //         'email' => 'required|email|unique:admins,email',
    //         'password' => 'required',
    //         'confirm_password' => 'required|same:password',
    //         'noHp' => 'required|numeric',
    //     ]);

    //     if ($validator->fails()) {
    //         $errors = $validator->errors();

    //         $responseMessage = 'Validation failed';

    //         // Check for specific field errors and customize the response message
    //         if ($errors->has('email')) {
    //             $responseMessage = $errors->first('email');
    //         } elseif ($errors->has('confirm_password')) {
    //             $responseMessage = 'The password confirmation does not match';
    //         } elseif ($errors->has('name')) {
    //             $responseMessage = $errors->first('name');
    //         }
    //         // Add similar checks for other fields if needed

    //         return response()->json([
    //             'success' => false,
    //             'message' => $responseMessage,
    //         ]);
    //     }

    //     $input = $request->all();

    //     // Check if the email already exists in the database
    //     $existingEmail = Admin::where('email', $input['email'])->first();

    //     if ($existingEmail) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'The email has already been taken',
    //         ]);
    //     }

    //     $input['password'] = bcrypt($input['password']);

    //     // Ensure 'noHp' is added to the fillable property in the Admin model
    //     $user = Admin::create($input);

    //     $success['email'] = $user->email;
    //     $success['name'] = $user->name;
    //     $success['noHp'] = $user->noHp;

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Registration successful',
    //         'data' => $success
    //     ]);
    // }


    public function Daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:admins,username',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'noHp' => 'required|numeric|unique:admins,noHp',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Menambahkan validasi untuk file gambar (opsional)
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            $responseMessage = 'Validation failed';

            // Check for specific field errors and customize the response message
            if ($errors->has('email')) {
                $responseMessage = $errors->first('email');
            } elseif ($errors->has('confirm_password')) {
                $responseMessage = 'The password confirmation does not match';
            } elseif ($errors->has('name')) {
                $responseMessage = $errors->first('name');
            } elseif ($errors->has('username')) {
                $responseMessage = $errors->first('username');
            } elseif ($errors->has('noHp')) {
                $responseMessage = $errors->first('noHp');
            } elseif ($errors->has('photo')) {
                $responseMessage = $errors->first('photo');
            }

            return response()->json([
                'success' => false,
                'message' => $responseMessage,
            ]);
        }

        $input = $request->all();

        // Check if the email, username, or noHp already exists in the database
        $existingEmail = Admin::where('email', $input['email'])->first();
        $existingUsername = Admin::where('username', $input['username'])->first();
        $existingNoHp = Admin::where('noHp', $input['noHp'])->first();

        if ($existingEmail || $existingUsername || $existingNoHp) {
            $responseMessage = 'Duplicate entry in the database';
            if ($existingEmail) {
                $responseMessage .= ': Email already exists';
            }
            if ($existingUsername) {
                $responseMessage .= ': Username already exists';
            }
            if ($existingNoHp) {
                $responseMessage .= ': No. HP already exists';
            }

            return response()->json([
                'success' => false,
                'message' => $responseMessage,
            ]);
        }

        // Upload and store the photo if provided
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->storeAs('akun/photo', uniqid() . '.' . $photo->extension(), 'public');
            $photoURL = URL::to('/') . '/storage/' . $photoPath;
            $input['photo'] = $photoURL;
        }

        $input['password'] = bcrypt($input['password']);
        $input['active'] = 'true';

        // Ensure 'noHp' is added to the fillable property in the Admin model
        $user = Admin::create($input);

        $success['email'] = $user->email;
        $success['name'] = $user->name;
        $success['noHp'] = $user->noHp;
        $success['photo'] = $user->photo ?? null;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => $success,
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
        if (!$request->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak boleh kosong',
                'data' => null
            ]);
        }

        // Cari user berdasarkan email
        $admin = Admin::where('email', $request->email)->first();

        // Jika user tidak ditemukan, kembalikan respons error
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Cek kembali email',
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
                'name' => $admin->name, // Include name if needed
                'user_id' => $admin->id,
                'photo' => $admin->photo,
                'email' => $admin->email,
                'noHp' => $admin->noHp,

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
                'photo' => $admin->photo,
                'email' => $admin->email,
                'noHp' => $admin->noHp,
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