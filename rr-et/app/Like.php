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

    public function isLiked(int $id, int $scriptId)
    {
        $likedScript = Like::where('user_id', $id)->where('script_id', $scriptId)->get();

        return $likedScript->isEmpty() ? false : true;
    }
}
