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

    public function store(CreateComment $request, int $id)
    {
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->script_id = $id;
        $comment->content = $request->content;
        $comment->save();

        session()->regenerateToken();
        session()->flash('status', 'コメントを投稿しました。');

        return redirect()->back();
    }
    
    public function destroy(int $id)
    {
        $comment = Comment::where('id', $id)->with('user')->with('script')->first();

        if (($comment->user->id !== Auth::user()->id) && (Auth::user()->role !== 1 )) {
            return redirect()->route('scripts.index')->with('errors', 'ユーザーが不正です。');
        }

        $comment->delete();

        session()->regenerateToken();
        session()->flash('status', 'コメントを削除しました。');

        return redirect()->back();
    }
}
