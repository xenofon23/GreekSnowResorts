<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiftAvailability extends Model
{
    use HasFactory;
    protected $table = 'lift_availability';
    protected $fillable = ['snow_resort_id', 'name','is_open', 'date'];

    public function snowResort()
    {
        return $this->belongsTo(SnowResorts::class);
    }

}
