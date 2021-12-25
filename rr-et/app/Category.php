<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Script;

class Category extends Model
{
    public function scripts()
    {
        return $this->hasMany('App\Script');
    }
}
