<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankWd extends Model
{
    use HasFactory;

    protected $table = 'bank_wd';
    protected $fillable = ['nama_bank', 'icons','active'];
}
