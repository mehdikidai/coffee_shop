<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $connection = 'system';


    protected $table = 'tenants';


    protected $fillable = [
        'name',
        'domain',
        'db_name',
        'tenant_token',
        'email',
        'db_user'
    ];
}
