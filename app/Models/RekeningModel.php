<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RekeningModel extends Model
{
    use HasFactory;
    protected $table = 'rekening';
    protected $primaryKey = 'id';

    protected $fillable = ['nama_bank', 'no_rekening'];
}
