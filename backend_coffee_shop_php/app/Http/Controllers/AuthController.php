<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enum\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TenantService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);


        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], (string) $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $tenantName = TenantService::$tenantName;

        $token = $user->createToken("{$user->id}-AuthToken")->plainTextToken;

        $user->email_verified = $user->email_verified_at !== NULL;

        $res = [
            'token' => $token,
            'tenant_name' => $tenantName,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'table' => $user->table_number
            ]
        ];

        return response()->json($res);
    }


    /**
     * login bay key
     * */

    public function loginByQrCode(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|min:8|max:64',
        ]);

        $user = User::where('table_key', $data['key'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid QR Code or user not found'
            ], 404);
        }

        $token = $user->createToken("{$user->id}-QRToken")->plainTextToken;

        $res = [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'table' => $user->table_number
            ]
        ];

        return response()->json($res);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        do {
            $key = Str::random(64);
        } while (User::where('table_key', $key)->exists());

        $validated['table_key'] = $key;
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = UserRole::USER->value;

        $user = User::create($validated);

        $token = $user->createToken("{$user->id}-QRToken")->plainTextToken;

        $res = [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'table' => $user->table_number
            ]
        ];

        return response()->json($res);
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
