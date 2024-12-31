<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;
    protected $fillable = ['type','activity','language'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
