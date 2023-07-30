<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BannerModel extends Model
{
    use HasFactory;
    protected $table = 'banner';
    protected $primaryKey = 'id';

    protected $fillable = ['image', 'title', 'subtitle'];
}
