<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLogin extends Model
{
    protected $fillable = ['user_id', 'login_at', 'logout_at', 'key_login', 'ip_address', 'os', 'browser','device'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
