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
        $status_draft = 2;

        if ($loggedInUser->id !== $selectedUser->id) {
            return redirect()->route('scripts.index');
        }
        $scripts = $loggedInUser->scripts()->where('status', $status_draft)->get();

        // dd(count($scripts));

        return view('drafts.index', compact('scripts'));
    }
}
