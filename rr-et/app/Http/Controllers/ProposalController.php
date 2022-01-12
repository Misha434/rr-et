<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proposal;
use App\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateProposal;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
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
        $proposals = Proposal::all();

        return view('proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProposal $request)
    {
        $proposal = new Proposal();
        $loggedInUser = Auth::user();

        $proposal->name = $request->name;
        $proposal->user_id = $loggedInUser->id;
        $proposal->save();

        session()->regenerateToken();
        session()->flash('status', 'ご協力ありがとうございました。');

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
        $roleAdmin = 1;
        if (Auth::user()->role !== $roleAdmin) {
            return redirect()->route('scripts.index')->with('error', 'アクセス権限がありません。');
        }

        $proposal = Proposal::findOrFail($id)->first();

        $proposal->delete();

        return redirect()->route('proposals.index')->with('status', 'カテゴリーを削除しました。');
    }

    public function aprove(int $id)
    {
        $roleAdmin = 1;
        if (Auth::user()->role ==! $roleAdmin) {
            return redirect()->route('scripts.index')->with('error', 'アクセス権限がありません。');
        }

        $proposal = Proposal::findOrFail($id);

        $aprovedCategory = new Category();
        $aprovedCategory->name = $proposal->name;
        
        $duplicatedProposals = Proposal::where('name', $aprovedCategory->name)->get();
        
        if (count($duplicatedProposals)) {
            DB::beginTransaction();
            try {
                foreach($duplicatedProposals as $duplicatedProposal) {
                    $duplicatedProposal->delete();
                }
                $aprovedCategory->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            $aprovedCategory->save();
        }

        session()->regenerateToken();
        session()->flash('status', 'カテゴリーを採用しました。');

        return redirect()->route('categories.index');
    }
}
