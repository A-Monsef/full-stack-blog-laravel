<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $isApi;
    public function __construct(Request $request)
    {
        $this->isApi = $request->segment(1) == "api" ? true : false;
    }
    //
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login successful',
                'user' => Auth::user(),
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'You have been logged out.']);
    }
}
