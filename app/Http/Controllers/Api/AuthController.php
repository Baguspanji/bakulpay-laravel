<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $users = User::all();
 
         return response()->json($users);
     }

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'number_phone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'message' => 'something wrong',
                'data' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);


        $success['email'] = $user->email;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'register successful',
            'data' => $success
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = User::where('email', $request->email)->first();

            $success['access_token'] = $user->createToken('auth_token')->plainTextToken;
            $success['token_type'] = 'Bearer';
            $success['name'] = $user->name;
            $success['user_id'] = $user->id;

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'data' => $success,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cek kembali email dan password',
                'data' => null
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        // Revoke the user's token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
