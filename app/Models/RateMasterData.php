<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateMasterData extends Model
{

    protected $table = 'rate_master_data';
    protected $fillable = ['nama_bank', 'icons', 'type', 'price'];

    use HasFactory;
}
