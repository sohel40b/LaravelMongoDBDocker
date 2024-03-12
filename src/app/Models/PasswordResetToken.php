<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $fillable = [
        'email', 'token'
    ];
}
