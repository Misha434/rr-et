<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUser;
use App\Script;
use Illuminate\Http\Request;
use App\User;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        $statusPosted = 1;

        $postedScripts = $user->scripts()->where('status', $statusPosted)->with('category')->withCount('likes')->withCount('comments')->orderBy('created_at','desc')->get();

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
            return redirect()->route('scripts.index');
        } elseif ($loggedInUser->email === 'guest-user@example.com') {
            return redirect()->route('scripts.index');
        } else {
            $loggedInUser->name = $request->name;
            $loggedInUser->email = $request->email;

            if (Hash::Check($request->current_password, $loggedInUser->password)) {
                if (!empty($request->password)) {
                    $loggedInUser->password = Hash::make($request->password);
                }

                $loggedInUser->save();

                return redirect()->route('users.show', ['id' => $loggedInUser->id])->with('status', '変更しました。');
            } else {
                throw ValidationException::withMessages([
                    'alert' => '登録済パスワード が間違いです。',
                ]);
            }

            return redirect()->route('scripts.index')->with('status', '変更しました。');
        }
    }

    public function destroy(int $id)
    {
        $selectedUser = User::findOrFail($id);
        $loggedInUser = Auth::user();

        if ($selectedUser->id !== $loggedInUser->id) {
            return redirect()->route('scripts.index');
        } elseif ($loggedInUser->email === 'guest-user@example.com') {
            return redirect()->route('scripts.index');
        } else {
            $selectedUser->delete();

            return redirect()->route('home')->with('status', '退会しました。');
        }
    }
}
