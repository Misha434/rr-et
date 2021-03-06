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

        $postedScripts = $user->scripts()->where('status', config('const.statusPublished'))
        ->with('category')->with('user')->with('comments.user')
        ->with('likes')->withCount('likes')->withCount('comments')
        ->orderBy('created_at', 'desc')->paginate(10);

        $pickingLikedScriptIds = array(\App\Like::where('user_id', $user->id)
        ->pluck('script_id'));

        $likedScripts = array();
        for ($i = 0; $i < count($pickingLikedScriptIds); $i++) {
            array_push($likedScripts, Script::findOrFail($pickingLikedScriptIds[$i])
            ->where('status', config('const.statusPublished')));
        }

        return view('users.show', compact('user', 'postedScripts', 'likedScripts'));
    }

    public function edit(int $id)
    {
        $selectedUser = User::findOrFail($id);
        $loggedInUser = Auth::user();

        if ($selectedUser->id !== $loggedInUser->id) {
            return redirect()->route('scripts.index')->with('alart', 'ユーザー情報が不正です。');
        } elseif ($loggedInUser->email === 'guest-user@example.com') {
            return redirect()->route('scripts.index')->with('alart', 'ゲストユーザーは編集できません。');
        } else {
            $user = $loggedInUser;
            return view('users.edit', compact('user'));
        }
    }

    public function update(EditUser $request, int $id)
    {
        $selectedUser = User::findOrFail($id);
        $loggedInUser = Auth::user();

        if ($selectedUser->id !== $loggedInUser->id) {
            return redirect()->route('scripts.index')->with('alart', 'ユーザー情報が不正です。');
        } elseif ($loggedInUser->email === 'guest-user@example.com') {
            return redirect()->route('scripts.index')->with('alart', 'ゲストユーザーは編集できません。');
        } else {
            $loggedInUser->name = $request->name;
            $loggedInUser->email = $request->email;

            if (Hash::Check($request->current_password, $loggedInUser->password)) {
                if (!empty($request->password)) {
                    $loggedInUser->password = Hash::make($request->password);
                }

                $loggedInUser->save();
                session()->regenerateToken();

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
            return redirect()->route('scripts.index')->with('alart', 'ユーザー情報が不正です。');
        } elseif ($loggedInUser->email === 'guest-user@example.com') {
            return redirect()->route('scripts.index')->with('alart', 'ゲストユーザーは編集できません。');
        } else {
            $selectedUser->delete();
            session()->regenerateToken();

            return redirect()->route('home')->with('status', '退会しました。');
        }
    }
}
