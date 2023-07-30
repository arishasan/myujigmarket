<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KecamatanModel extends Model
{
    use HasFactory;
    protected $table = 'tb_ro_subdistricts';
    protected $primaryKey = 'subdistrict_id';

    protected $fillable = [];
}
