<?php

namespace App\Helpers;

use App\Models\SnowResorts;

trait Helpers
{

    public function admin($snowResortId)
    {
        $admin=SnowResorts::find($snowResortId)?->getAdmin();

        return (boolean)$admin;
    }
}
