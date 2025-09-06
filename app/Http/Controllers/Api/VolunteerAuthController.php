<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class VolunteerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string|size:5',
        ]);

        $volunteer = Volunteer::where('phone', $request->phone)
            ->where('is_active', true)
            ->first();

        if (!$volunteer || $volunteer->password !== $request->password) {
            throw ValidationException::withMessages([
                'phone' => ['Nomor telepon atau PIN tidak valid.'],
            ]);
        }

        // Create token for volunteer
        $token = $volunteer->createToken('volunteer-token', ['volunteer'])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'volunteer' => $volunteer->load(['kabupaten', 'kecamatan', 'desa']),
                'token' => $token,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('volunteer')->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    public function profile(Request $request)
    {
        $volunteer = $request->user('volunteer')->load(['kabupaten', 'kecamatan', 'desa']);

        return response()->json([
            'success' => true,
            'data' => $volunteer
        ]);
    }
}