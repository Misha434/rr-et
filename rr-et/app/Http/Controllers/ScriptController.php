<?php

namespace App\Http\Controllers;

use App\Category;
use App\Script;
use Illuminate\Http\Request;
use App\Http\Requests\CreateScript;
use App\Http\Requests\EditScript;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ScriptController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Script::query();

        if (!empty($keyword)) {
            $query->where('content', 'LIKE', "%{$keyword}%");
        }

        $scripts_count = $query->count();

        $filteredScripts = $query->withCount('likes')->withCount('comments')->with('user')->with('category');
        $sortedScripts = $filteredScripts->orderBy('created_at', 'desc');
        $scripts = $sortedScripts->paginate(10);

        return view('scripts.index', compact('scripts', 'keyword', 'scripts_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('scripts/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateScript $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $script = new Script();

        $script->content = $request->content;
        $script->user_id = $userId;
        $script->category_id = $request->category_id;
        $script->save();

        return redirect()->route('scripts.index')->with('status', '投稿しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $script = Script::findOrFail($id);

        return view('scripts.show', compact('script'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $script = Script::findOrFail($id);

        $loggedInUser = Auth::user();
        if ($script->user_id !== $loggedInUser->id) {
            return redirect()->route('scripts.index');
        }

        $categories = Category::all();

        return view('scripts.edit', compact('script', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditScript $request, int $id)
    {
        $script = Script::findOrFail($id);

        $loggedInUser = Auth::user();
        if ($script->user_id !== $loggedInUser->id) {
            return redirect()->route('scripts.index');
        }

        if ($script->content !== $request->content){
            $script->content = $request->content;
            $script->likes()->delete();
            $script->content_updated_at = Carbon::now();
        }

        $script->category_id = $request->category_id;
        $script->save();

        return redirect()->route('scripts.index')->with('status', '編集完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $script = Script::findOrFail($id);

        $loggedInUser = Auth::user();
        if (($script->user_id !== $loggedInUser->id) && ($loggedInUser->role !== 1)) {
            return redirect()->route('scripts.index');
        }

        $script->delete();
        return redirect()->route('scripts.index')->with('status', '削除しました。');
    }

    public function ajaxlike(Request $request)
    {
        $postUserId = Auth::user()->id;
        $scriptId = $request->script_id;
        $like = new Like;
        $script = Script::findOrFail($scriptId);

        if ($like->idLiked($postUserId, $scriptId)){
            $like = Like::where('script_id', $scriptId)->where('user_id', $postUserId)->delete();
        } else {
            $like = new Like;
            $like->script_id = $request->script_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }

        $scriptLikesCount = $script->loadCount('likes')->likes_count;

        $json = [
            'scriptLikesCount' => $scriptLikesCount,
        ];

        return response()->json($json);
    }
}
