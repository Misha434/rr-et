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
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'category_id',
    ];
}
