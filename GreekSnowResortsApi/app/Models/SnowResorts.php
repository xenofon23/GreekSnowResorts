<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnowResorts extends Model
{
    use HasFactory;
    protected $hidden = ['admin'];

    protected $fillable = ['name', 'description'];

    public function getAdmin()
    {
        return $this->attributes['admin'];
    }
}
