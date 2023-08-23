<?php

namespace CodebarAg\LaravelAuth\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthProvider extends Model
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
