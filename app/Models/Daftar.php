<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    use HasFactory;
    protected $table = "daftar";
    protected $fillable = ['name',
                            'username',
                            'number_phone',
                            'email',
                            'password'];
}
