<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function isLiked(int $scriptId, int $userId)
    {
        $likedScript = Like::where('user_id', $userId)->where('script_id', $scriptId)->get();

        return $likedScript->isEmpty() ? false : true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'category_id',
    ];
}
