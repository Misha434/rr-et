<?php

namespace App\Http\Controllers;

use App\Script;
use Illuminate\Http\Request;
use App\Http\Requests\CreateScript;
use App\Http\Requests\EditScript;

class ScriptController extends Controller
{
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

        $scripts = $query->get();

        return view('scripts.index', compact('scripts', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('scripts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateScript $request)
    {
        $script = new Script();
        $script->content = $request->content;
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

        return view('scripts/edit', [
            'script' => $script,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditScript $request, $id)
    {
        $script = Script::find($id);

        $script->content = $request->content;
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

        $script->delete();
        return redirect(route('scripts.index'));
    }
}
