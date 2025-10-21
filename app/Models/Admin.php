<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        // tambahkan kolom lain jika tabel admins Anda punya kolom tambahan
    ];

    public $timestamps = true;
}
