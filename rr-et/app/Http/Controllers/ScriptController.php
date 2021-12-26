<?php

namespace App\Http\Controllers;

use App\Category;
use App\Script;
use Illuminate\Http\Request;
use App\Http\Requests\CreateScript;
use App\Http\Requests\EditScript;
use Illuminate\Support\Facades\Auth;

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

        $scripts = $query->with('user')->with('category')->get();

        return view('scripts.index', compact('scripts', 'keyword'));
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

        return redirect()->route('scripts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $script = Script::find($id);

        return view('scripts/show', [
            'script' => $script,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $script = Script::find($id);

        $loggedInUser = Auth::user();
        if ($script->user_id !== $loggedInUser->id) {
            return redirect()->route('scripts.index');
        }

        $categories = Category::all();

        return view('scripts/edit', compact('script', 'categories'));
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
        $script = Script::find($id);

        $loggedInUser = Auth::user();
        if ($script->user_id !== $loggedInUser->id) {
            return redirect()->route('scripts.index');
        }

        $script->content = $request->content;
        $script->category_id = $request->category_id;
        $script->save();

        return redirect()->route('scripts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $script = Script::find($id);

        $loggedInUser = Auth::user();
        if ($script->user_id !== $loggedInUser->id) {
            return redirect()->route('scripts.index');
        }

        $script->delete();
        return redirect(route('scripts.index'));
    }
}
