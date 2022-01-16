<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CreateCategory;
use App\Http\Requests\EditCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
    public function index()
    {
        $categories = Category::paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategory $request)
    {
        $category = new Category();

        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $category = Category::findOrFail($id);

        $scripts = $category->scripts()
        ->where('status', config('const.statusPublished'))
        ->with('user')->with('category')->with('likes')->with('comments.user')
        ->withCount('comments')->paginate(10);

        return view('categories.show', compact('category', 'scripts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $category = Category::findOrfail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCategory $request, int $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        $relatedScripts = $category->scripts()->get();

        if (count($relatedScripts)) {
            $uncategorizeId = Category::firstOrCreate(['name' => '未分類'])->id;

            foreach ($relatedScripts as $relatedScript) {
                $relatedScript->category_id = $uncategorizeId;
                $relatedScript->save();
            }
        }

        $category->delete();

        return redirect()->route('categories.index')->with('status', 'カテゴリーを削除しました。');
    }
}
