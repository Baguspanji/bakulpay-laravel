<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMasterData extends Model
{

    protected $table = 'payment_master_data';
    protected $fillable = ['nama_bank', 'icons', 'nama', 'no_rekening','active'];
    use HasFactory;
}
