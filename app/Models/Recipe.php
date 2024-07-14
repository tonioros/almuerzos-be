<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    use HasFactory;

    protected $fillable = ['name', 'avg_preparation_time', 'url_image'];
}
