<?php

namespace App\Http\Controllers\web;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setting', ['languages' => $this->languages]);
    }

    /**
     * change lang
     */

    public function lang($locale)
    {
        if (!array_key_exists($locale, $this->languages)) {
            abort(400);
        }

        Session::put('locale', $locale);
        App::setLocale($locale);
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'daily_expected_income' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
        ]);


        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

    
        foreach (array_keys($validated) as $key) {
            cache()->forget("setting_{$key}");
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    private $languages = [
        'en' => ['name' => 'English', 'flag' => 'https://countryflagsapi.netlify.app/flag/gb.svg'],
        'fr' => ['name' => 'Français', 'flag' => 'https://countryflagsapi.netlify.app/flag/fr.svg'],
        'ar' => ['name' => 'العربية', 'flag' => 'https://countryflagsapi.netlify.app/flag/ma.svg'],
    ];
}
