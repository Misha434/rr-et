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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

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
        $sortCondition = $request->get('sort');

        $query = Script::query();

        switch ($sortCondition) {
            case '新規投稿順':
                $query->orderBy('created_at', 'desc');
                break;
            case 'いいね数':
                $query->orderBy('likes_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Advanved Search Start
        $categories = Category::all();

        $advancedSearchFilters = [
            'keyword' => $keyword,
            'category' => $request->input('advanced_search_category'),
            'dateStart' => $request->input('advanced_search_date_start'),
            'dateEnd' => $request->input('advanced_search_date_end'),
        ];

        $keywordOnly = !empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        $categoryOnly = empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        $startDayOnly = empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        $endDayOnly = empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $keywordAndCategory = !empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        $keywordAndStartDate = !empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        $keywordAndEndDate = !empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $categoryAndStartDate = empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        $categoryAndEndDate = empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $startDateAndEndDate = empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $exceptKeyword = empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $exceptCategory = !empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $exceptDateStart = !empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $exceptDateEnd = !empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        $searchAllOption = !empty($advancedSearchFilters['keyword'])
                    && !empty($advancedSearchFilters['category'])
                    && !empty($advancedSearchFilters['dateStart'])
                    && !empty($advancedSearchFilters['dateEnd']);

        $emptyAll = empty($advancedSearchFilters['keyword'])
                    && empty($advancedSearchFilters['category'])
                    && empty($advancedSearchFilters['dateStart'])
                    && empty($advancedSearchFilters['dateEnd']);

        if ($keywordOnly) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%");
        }

        if ($categoryOnly) {
            $query->where('category_id', $advancedSearchFilters['category']);
        }

        if ($startDayOnly) {
            $query->whereDate('created_at', '>=', $advancedSearchFilters['dateStart']);
        }

        if ($endDayOnly) {
            $query->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($keywordAndCategory) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%")
            ->where('category_id', $advancedSearchFilters['category']);
        }

        if ($keywordAndStartDate) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%")
            ->whereDate('created_at', '>=', $advancedSearchFilters['dateStart']);
        }

        if ($keywordAndEndDate) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%")
            ->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($categoryAndStartDate) {
            $query->where('category_id', $advancedSearchFilters['category'])
            ->whereDate('created_at', '>=', $advancedSearchFilters['dateStart']);
        }

        if ($categoryAndEndDate) {
            $query->where('category_id', $advancedSearchFilters['category'])
            ->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($startDateAndEndDate) {
            $query->whereDate('created_at', '>=', $advancedSearchFilters['dateStart'])
            ->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($exceptKeyword) {
            $query->where('category_id', $advancedSearchFilters['category'])
            ->whereDate('created_at', '>=', $advancedSearchFilters['dateStart'])
            ->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($exceptCategory) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%")
            ->whereDate('created_at', '>=', $advancedSearchFilters['dateStart'])
            ->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($exceptDateStart) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%")
            ->where('category_id', $advancedSearchFilters['category'])
            ->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($exceptDateEnd) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%")
            ->where('category_id', $advancedSearchFilters['category'])
            ->whereDate('created_at', '>=', $advancedSearchFilters['dateStart']);
        }

        if ($searchAllOption) {
            $query->where('content', 'LIKE', "%{$advancedSearchFilters['keyword']}%")
            ->where('category_id', $advancedSearchFilters['category'])
            ->whereDate('created_at', '>=', $advancedSearchFilters['dateStart'])
            ->whereDate('created_at', '<=', $advancedSearchFilters['dateEnd']);
        }

        if ($emptyAll) {
            // none
        }

        // advanced search end

        $publisingScripts = $query->where('status', config('const.statusPublished'));

        $scripts_count = $publisingScripts->count();

        $filteredScripts = $publisingScripts->with('likes')->withCount('comments')
        ->with('comments')->with('comments.user')
        ->with('user')->with('category');

        $scripts = $filteredScripts->paginate(10);

        return view('scripts.index', compact('scripts', 'keyword', 'scripts_count', 'sortCondition', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $script = new Script(); 
        $categories = Category::all();

        return view('scripts/create', [
            'categories' => $categories,
            'script' => $script,
        ]);
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
        $script->user_id = Auth::user()->id;
        $script->category_id = $request->category_id;
        if ($request->has('store')) {
            $script->status = config('const.statusPublished');

            if ($request->script_img !== null) {
                $image = $request->file('script_img');

                if (app()->isLocal()) {
                    $fileName = time() . $image->getClientOriginalName();
                    $target_path = public_path('uploads/');
                    Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($target_path . $fileName);
                    $script->script_img = '/uploads/' . $fileName;
                } else {
                    $extension = $request->file('script_img')->getClientOriginalExtension();
                    $fileName = time() . "_" . $request->file('script_img')->getClientOriginalName();
                    $resizeImg = Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);
                    $path = Storage::disk('s3')->put('/scripts/' . $fileName, (string)$resizeImg);

                    $script->script_img = "scripts/" . $fileName;
                }
            }

            $script->save();

            session()->regenerateToken();
            session()->flash('status', '投稿しました。');
        } elseif ($request->has('draft')) {
            $script->status = config('const.statusDraft');

            if ($request->script_img !== null) {
                $image = $request->file('script_img');

                if (app()->isLocal()) {
                    $fileName = time() . $image->getClientOriginalName();
                    $target_path = public_path('uploads/');
                    Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($target_path . $fileName);
                    $script->script_img = '/uploads/' . $fileName;
                } else {
                    $extension = $request->file('script_img')->getClientOriginalExtension();
                    $fileName = time() . "_" . $request->file('script_img')->getClientOriginalName();
                    $resizeImg = Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);
                    $path = Storage::disk('s3')->put('/scripts/' . $fileName, (string)$resizeImg);

                    $script->script_img = "scripts/" . $fileName;
                }
            }

            $script->save();

            session()->regenerateToken();
            session()->flash('status', '下書きに保存しました。');
        } else {
            $script->status = config('const.statusPublished');

            if ($request->script_img !== null) {
                $image = $request->file('script_img');

                if (app()->isLocal()) {
                    $fileName = time() . $image->getClientOriginalName();
                    $target_path = public_path('uploads/');
                    Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($target_path . $fileName);
                    $script->script_img = '/uploads/' . $fileName;
                } else {
                    $extension = $request->file('script_img')->getClientOriginalExtension();
                    $fileName = time() . "_" . $request->file('script_img')->getClientOriginalName();
                    $resizeImg = Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);
                    $path = Storage::disk('s3')->put('/scripts/' . $fileName, (string)$resizeImg);

                    $script->script_img = "scripts/" . $fileName;
                }
            }

            $script->save();

            session()->regenerateToken();
            session()->flash('status', '投稿しました。');
        }

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

        if ($script->user_id !== Auth::user()->id) {
            return redirect()->route('scripts.index')->with('alert', 'ユーザー情報が不正です');
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

        if ($script->user_id !== Auth::user()->id) {
            return redirect()->route('scripts.index')->with('alert', 'ユーザー情報が不正です');
        }

        if ($script->content !== $request->content) {
            $script->content = $request->content;
            $script->likes()->delete();
            $script->content_updated_at = Carbon::now();
        }

        $script->category_id = $request->category_id;

        if ($request->has('store')) {
            $script->status = config('const.statusPublished');

            if ($request->boolean('deleting') === true) {
                $image = $script->script_img;
                if (app()->isLocal()) {
                    $target_path = public_path();
                    File::delete($target_path . $image);
                } else {
                    Storage::disk('s3')->delete($image);
                }
                $script->script_img = null;
            }

            if ($request->script_img !== null) {
                $image = $request->file('script_img');

                if (app()->isLocal()) {
                    $fileName = time() . $image->getClientOriginalName();
                    $target_path = public_path('uploads/');
                    Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($target_path . $fileName);
                    $script->script_img = '/uploads/' . $fileName;
                } else {
                    $extension = $request->file('script_img')->getClientOriginalExtension();
                    $fileName = time() . "_" . $request->file('script_img')->getClientOriginalName();
                    $resizeImg = Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);
                    $path = Storage::disk('s3')->put('/scripts/' . $fileName, (string)$resizeImg);

                    $script->script_img = "scripts/" . $fileName;
                }
            }

            $script->save();

            session()->regenerateToken();
            session()->flash('status', '編集しました。');
        } elseif ($request->has('draft')) {
            $script->status = config('const.statusDraft');

            if ($request->boolean('deleting') === true) {
                $image = $script->script_img;
                if (app()->isLocal()) {
                    $target_path = public_path();
                    File::delete($target_path . $image);
                } else {
                    Storage::disk('s3')->delete($image);
                }
                $script->script_img = null;
            }

            if ($request->script_img !== null) {
                $image = $request->file('script_img');

                if (app()->isLocal()) {
                    $fileName = time() . $image->getClientOriginalName();
                    $target_path = public_path('uploads/');
                    Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($target_path . $fileName);
                    $script->script_img = '/uploads/' . $fileName;
                } else {
                    $extension = $request->file('script_img')->getClientOriginalExtension();
                    $fileName = time() . "_" . $request->file('script_img')->getClientOriginalName();
                    $resizeImg = Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);
                    $path = Storage::disk('s3')->put('/scripts/' . $fileName, (string)$resizeImg);

                    $script->script_img = "scripts/" . $fileName;
                }
            }

            $script->save();

            session()->regenerateToken();
            session()->flash('status', '下書きに保存しました。');
        } else {
            $script->status = config('const.statusPublished');

            if ($request->boolean('deleting') === true) {
                $image = $script->script_img;
                if (app()->isLocal()) {
                    $target_path = public_path();
                    File::delete($target_path . $image);
                } else {
                    Storage::disk('s3')->delete($image);
                }
                $script->script_img = null;
            }

            if ($request->script_img !== null) {
                $image = $request->file('script_img');

                if (app()->isLocal()) {
                    $fileName = time() . $image->getClientOriginalName();
                    $target_path = public_path('uploads/');
                    Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($target_path . $fileName);
                    $script->script_img = '/uploads/' . $fileName;
                } else {
                    $extension = $request->file('script_img')->getClientOriginalExtension();
                    $fileName = time() . "_" . $request->file('script_img')->getClientOriginalName();
                    $resizeImg = Image::make($image)->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);
                    $path = Storage::disk('s3')->put('/scripts/' . $fileName, (string)$resizeImg);

                    $script->script_img = "scripts/" . $fileName;
                }
            }

            $script->save();

            session()->regenerateToken();
            session()->flash('status', '編集しました。');
        }

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

        if (($script->user_id !== Auth::user()->id) && (Auth::user()->role !== config('const.roleAdmin'))) {
            return redirect()->route('scripts.index');
        }

        if ($script->script_img !== null) {
            $fileName = $script->script_img;
            if (app()->isLocal()) {
                File::delete(public_path() . $fileName);
            } else {
                Storage::disk('s3')->delete($fileName);
            }
        }

        $script->delete();
        session()->regenerateToken();

        return redirect()->route('scripts.index')->with('status', '削除しました。');
    }

    public function ajaxlike(Request $request)
    {
        $postUserId = Auth::user()->id;
        $scriptId = $request->script_id;
        $like = new Like();
        $script = Script::findOrFail($scriptId);

        if ($like->idLiked($postUserId, $scriptId)) {
            $like = Like::where('script_id', $scriptId)->where('user_id', $postUserId)->delete();
        } else {
            $like = new Like();
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
