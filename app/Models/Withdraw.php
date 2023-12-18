<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = "withdraw";
    protected $fillable = [
        'user_id',
        'product',
        'price_rate',
        'id_pembayaran',
        'rek_client',
        'jumlah',
        'total_pembayaran',
        'nama_bank',
        'nama',
        'status',
        'tanggal',
        'bukti_pembayaran'
    ];
    use HasFactory;

    public function rateMasterData()
    {
        return $this->belongsTo(RateMasterData::class, 'nama_bank', 'nama_bank');
    }
}
