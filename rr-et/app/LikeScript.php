<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeScript extends Model
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
        $likedScript = LikeScript::where('user_id', $id)->where('script_id', $scriptId)->get();

        return $likedScript->isEmpty() ? false : true;
    }
}
