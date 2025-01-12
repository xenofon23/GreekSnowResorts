<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['content', 'snow_resort_id','post_identifier'];
    protected $hidden = ['updated_at', 'snow_resort_id','post_identifier'];
    public function snowResort()
    {
        return $this->belongsTo(SnowResorts::class);
    }
}
