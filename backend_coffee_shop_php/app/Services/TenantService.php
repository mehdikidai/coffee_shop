<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TenantService
{


    public static ?string $tenantName = null;
    public static ?string $tenantToken = null;
    /**
     * Create a new class instance.
     */
    public static function switchToTenant(?Tenant $tenant): void
    {
        if (!$tenant) abort('404', 'Tenant not found');
        Config::set('database.connections.tenant.database', $tenant->db_name);
        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');
        Self::$tenantName = $tenant->name;
        Self::$tenantToken = $tenant->tenant_token;

    }

    public static function switchToDefault(): void
    {
        DB::purge('tenant');
        DB::purge('system');
        DB::reconnect('system');
        DB::setDefaultConnection('system');

    }
}
