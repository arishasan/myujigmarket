<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KotaModel extends Model
{
    use HasFactory;
    protected $table = 'tb_ro_cities';
    protected $primaryKey = 'city_id';

    protected $fillable = [];
}
