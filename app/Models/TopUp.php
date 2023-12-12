<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $table = "top_up";
    protected $fillable = [
        'user_id',
        'email',
        'jumlah',
        'total_pembayaran',
        'nama_bank',
        'kode_bank_client',
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
