<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function script()
    {
        $this->belongsTo(Script::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'script_id', 'user_id'
    ];
}
