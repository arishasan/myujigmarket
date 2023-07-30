<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KategoriModel extends Model
{
    use HasFactory;
    protected $table = 'kategori_produk';
    protected $primaryKey = 'id';

    protected $fillable = ['nama'];
}
