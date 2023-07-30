<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WishlistModel extends Model
{
    use HasFactory;
    protected $table = 'wishlist';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_produk',
    ];
}
