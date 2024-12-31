<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnowReport extends Model
{
    use HasFactory;
    protected $table = 'snow_reports';
    protected $fillable = [
        'snow_resort_id',
        'last_snowfall',
        'depth_base',
        'depth_top',
        'snow_quality',
        'depth_middle'
    ];
    protected $hidden = ['id','created_at',
        'updated_at','snow_resort_id'];
    public function snowResort()
    {
        return $this->belongsTo(SnowResorts::class);
    }

}
