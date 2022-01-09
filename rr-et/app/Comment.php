<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function script()
    {
        $this->belongsTo('\App\Script');
    }

    public function user()
    {
        $this->belongsTo('\App\User');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'script_id', 'user_id', 'content'
    ];
}
