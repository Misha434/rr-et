<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateLike;
use Illuminate\Support\Facades\Auth;
use App\Like;
use App\Script;

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

        $likedScript = Script::findOrFail($id);
        $likesCount = $likedScript->likes()->count();
        $likedScript->likes_count = $likesCount;
        $likedScript->save();

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

        $unlikedScript = Script::findOrFail($id);
        $likesCount = $unlikedScript->likes()->count();

        $unlikedScript->likes_count = $likesCount;
        $unlikedScript->save();

        session()->regenerateToken();
        session()->flash('status', 'いいねを解除しました。');

        return redirect()->back();
    }
}
