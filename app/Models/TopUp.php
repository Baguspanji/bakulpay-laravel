<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $table = "top_up";
    protected $fillable = ['email',
                            'jumlah',
                            'total_pembayaran',
                            'bank',
                            'kode_bank',
                            'nama',
                            'bukti_pembayaran'];
    use HasFactory;
}
