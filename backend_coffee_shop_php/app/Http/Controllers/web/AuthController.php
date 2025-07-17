<?php

namespace App\Http\Controllers\web;

use Carbon\Carbon;
use App\Enum\UserRole;
use App\Models\UserLogin;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Services\TenantService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pageLogin()
    {
        $app_name = TenantService::$tenantName;
        $languages = $this->languages;
        return view('login', compact('app_name', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $loginData = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
                'remember_me' => ['nullable'],
            ]
        );

        $remember = $request->boolean('remember_me');

        if (Auth::attempt([

            'email' => $loginData['email'],
            'password' => $loginData['password'],

        ], $remember)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if (!in_array($user->role, [UserRole::ADMIN->value, UserRole::BARISTA->value])) {
                Auth::logout();
                return back()->withErrors(['email' => 'You do not have permission to enter.']);
            }

            $agent = new Agent();

            $browser = $agent->browser() . ' ' . $agent->version($agent->browser());
            $platform = $agent->platform() . ' ' . $agent->version($agent->platform());
            $ip = $request->ip();

            $device = match (true) {
                $agent->isMobile() => 'mobile',
                $agent->isTablet() => 'tablet',
                $agent->isDesktop() => 'desktop',
                default => 'unknown',
            };

            $keyLogin = (string) Str::uuid();
            $request->session()->put('key_login', $keyLogin);

            $user->accessLogs()->create([
                'login_at' => now(),
                'key_login' => $keyLogin,
                'ip_address' => $ip,
                'browser' => $browser,
                'os' => $platform,
                'device' => $device,
            ]);

            return redirect()->intended('/');
        } else {

            return back()->withErrors(['email' => 'Email or password is incorrect.']);
        }
    }

    // logout

    public function logout(Request $request)
    {


        $keyLogin = $request->session()->get('key_login');

        $lastLog = UserLogin::where('key_login', $keyLogin)->first();

        $lastLog->logout_at = Carbon::now();

        $lastLog->save();

        //dd($lastLog);

        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }

    private $languages = [
        'en' => ['name' => 'English', 'flag' => 'https://countryflagsapi.netlify.app/flag/gb.svg'],
        'fr' => ['name' => 'Français', 'flag' => 'https://countryflagsapi.netlify.app/flag/fr.svg'],
        'ar' => ['name' => 'العربية', 'flag' => 'https://countryflagsapi.netlify.app/flag/ma.svg'],
    ];
}
