<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class DraftController extends Controller
{
    
    public function index(int $id)
    {
        $selectedUser = User::findOrFail($id);
        $loggedInUser = Auth::user();

        if ($loggedInUser->id !== $selectedUser->id) {
            return redirect()->route('scripts.index');
        }
        $scripts = $loggedInUser->scripts()->where('status', config('const.statusDraft'))->get();

        return view('drafts.index', compact('scripts'));
    }
}
