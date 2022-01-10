<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUser;
use App\Script;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

    public function show(int $id)
    {
        $user = User::findOrFail($id);
        $postedScripts = $user->scripts()->with('category')->get();

        $pickingLikedScriptIds = array(\App\Like::where('user_id', $user->id)->pluck('script_id'));
        $likedScripts = array();
        for($i = 0; $i < count($pickingLikedScriptIds); $i++){
            array_push($likedScripts, Script::find($pickingLikedScriptIds[$i]));
        }

        return view('users.show', compact('user', 'postedScripts', 'likedScripts'));
    }

    public function edit(int $id)
    {
        $selectedUser = User::findOrFail($id);
        $loggedInUser = Auth::user();

        if ($selectedUser->id !== $loggedInUser->id) {
            $scripts = Script::all();
            return redirect()->route('scripts.index', compact('scripts'));
        } elseif ($loggedInUser->email === 'guest-user@example.com') {
            $scripts = Script::all();
            return redirect()->route('scripts.index', compact('scripts'));
        } else {
            $user = $loggedInUser;
            return view('users.edit', compact('user'));
        }
    }

    public function update(EditUser $request, $id)
    {
        $selectedUser = User::findOrFail($id);
        $loggedInUser = Auth::user();

        if ($selectedUser->id !== $loggedInUser->id) {
            $scripts = Script::all();
            return redirect()->route('scripts.index', compact('scripts'));
        } elseif ($loggedInUser->email === 'guest-user@example.com') {
            $scripts = Script::all();
            return redirect()->route('scripts.index', compact('scripts'));
        } else {
            $loggedInUser->name = $request->name;
            $loggedInUser->email = $request->email;
            $loggedInUser->password = $request->password;
    
            $loggedInUser->save();
    
            return redirect()->route('scripts.index')->with('status', '変更しました。');
        }
    }
}
