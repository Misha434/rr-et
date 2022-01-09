<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateLike;
use Illuminate\Support\Facades\Auth;
use App\Like;

class LikeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Create a new controller instance.
     *
     * @param $id script_id
     */
    public function store(int $id)
    {
        Like::create([
            'script_id' => $id,
            'user_id' => Auth::user()->id,
        ]);

        session()->regenerateToken();

        session()->flash('status', 'いいねしました。');

        return redirect()->back();
    }

    /**
     * Create a new controller instance.
     *
     * @param $id script_id
     */
    public function destroy(int $id)
    {
        $loggedInUser = Auth::user();
        $like = Like::where('user_id', $loggedInUser->id)->where('script_id', $id)->first();
        $like->delete();

        session()->regenerateToken();
        session()->flash('status', 'いいねを解除しました。');

        return redirect()->back();
    }
}
