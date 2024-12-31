<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnowResorts extends Model
{
    use HasFactory;
    protected $hidden = ['admin','created_at',
        'updated_at'];
    protected $casts = [
        'activities' => 'array',
    ];
    protected $fillable = ['name', 'description'];

    public function getAdmin()
    {
        return $this->attributes['admin'];
    }
    public function snowReports()
    {
        return $this->hasMany(SnowReport::class, 'snow_resort_id');
    }
}
