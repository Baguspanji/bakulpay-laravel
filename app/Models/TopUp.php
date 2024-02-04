<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TopUp extends Model
{
    protected $table = "top_up";
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
        'bukti_pembayaran'
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
