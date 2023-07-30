<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProvinsiModel extends Model
{
    use HasFactory;
    protected $table = 'tb_ro_provinces';
    protected $primaryKey = 'province_id';

    protected $fillable = [];
}
