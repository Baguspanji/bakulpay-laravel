<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blockchain extends Model
{
    use HasFactory;

    protected $table = 'blockchain';
    protected $fillable = ['id_rate', 'nama_bank', 'nama_blockchain', 'rekening_wallet', 'type', 'price'];
}
