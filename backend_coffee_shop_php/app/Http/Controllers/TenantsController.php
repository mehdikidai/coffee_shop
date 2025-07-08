<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TenantService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $data = $request->validate([
            'name'   => 'required|string|min:3',
            'domain' => ['required', 'string', 'regex:/^[a-z0-9-]+$/i'],
            'password' => 'required|min:8', //987654321
            'email'    => 'required|email',
        ]);

        $domainName = env('APP_DOMAIN');
        $secretHash = env('APP_SECRET_HASH');

        if (!hash_equals($secretHash, md5($data['password']))) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        };


        $domain = $data['domain'] . '.' . $domainName;
        $db_name   = null;
        $tenant    = null;
        $createdDb = false;

        try {

            if (Tenant::where('domain', $domain)->exists()) {
                return response()->json(['message' => 'Domain already exists.'], 409);
            }

            do {
                $db_name = 'vov_' . $data['domain'] . '_' . Str::random(8);
            } while (Tenant::where('db_name', $db_name)->exists());


            DB::statement("CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $createdDb = true;


            DB::beginTransaction();

            $tenant = Tenant::create([
                'name'         => $data['name'],
                'email'         => $data['email'],
                'domain'       => $domain,
                'db_name'      => $db_name,
                'tenant_token' => Str::ulid(),
            ]);

            DB::commit();

            TenantService::switchToTenant($tenant);

            $exit = Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path'     => '/database/migrations/tenant',
                '--force'    => true,
            ]);

            if ($exit !== 0) {
                throw new \RuntimeException('Migrations failed');
            }

            app()->instance('admin_email', $data['email']);

            $exit = Artisan::call('db:seed', [
                '--database' => 'tenant',
                '--class'    => 'DatabaseSeeder',
                '--force'    => true
            ]);
            if ($exit !== 0) {
                throw new \RuntimeException('Seeding failed');
            }

            return response()->json(['message' => 'Tenant created successfully.'], 201);

        } catch (Throwable $e) {


            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            if ($tenant) {
                Tenant::where('id', $tenant->id)->delete();
            }

            if ($createdDb) {
                DB::statement("DROP DATABASE IF EXISTS `$db_name`");
            }


            Log::error('Tenant creation failed: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'message' => 'Tenant creation failed.',
                'error'   => $e->getMessage(),
            ], 500);

        }
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
