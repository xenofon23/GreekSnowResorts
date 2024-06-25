<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slopes extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'difficulty','difficulty','length_m','altitude_m','average_slope_percent','details','snow_resort_id'];


}
