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
        'nama_blockchain',
        'price_rate',
        'id_pembayaran',
        'rek_client',
        'jumlah',
        'total_pembayaran',
        'nama_bank',
        'nama',
        'status',
        'tanggal',
        'bukti_pembayaran',
        'bukti_tf'
    ];
    use HasFactory;

    public function rateMasterData()
    {
        return $this->belongsTo(RateMasterData::class, 'nama_bank', 'nama_bank');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
