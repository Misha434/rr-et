<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreateComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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

    public function store(CreateComment $request)
    {
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->script_id = $request->script->id;
        $comment->content = $request->content;
        $comment->save();

        session()->regenerateToken();
        session()->flash('status', 'コメントを投稿しました。');

        return redirect()->back();
    }
    
    public function destroy(int $id)
    {
        $loggedInUser = Auth::user();
        $comment = Comment::where('user_id', $loggedInUser->id)->where('script_id', $id)->first();
        $comment->delete();

        session()->regenerateToken();
        session()->flash('status', 'コメントを削除しました。');

        return redirect()->back();
    }
}
