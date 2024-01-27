<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateMasterData extends Model
{

    protected $table = 'rate_master_data';
    protected $fillable = ['nama_bank', 'icons', 'type', 'price','active','biaya_transaksi'];

    use HasFactory;

    public function blockchains()
    {
        return $this->hasMany(Blockchain::class, 'id_rate', 'id');
    }
}
