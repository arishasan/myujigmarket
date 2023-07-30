<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KodePromoModel extends Model
{
    use HasFactory;
    protected $table = 'kode_promo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_promo',
        'minimal_belanja',
        'type_promo',
        'value_promo',
        'periode_mulai',
        'periode_berakhir',
        'quota',
        'status',
        'create_user'
    ];
}
