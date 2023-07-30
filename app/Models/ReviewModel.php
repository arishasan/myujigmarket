<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewModel extends Model
{
    use HasFactory;
    protected $table = 'review';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'id_user',
        'rate',
        'catatan'
    ];
}
