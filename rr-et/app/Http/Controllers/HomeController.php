<?php

namespace App\Http\Controllers;

use App\Script;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $scripts = Script::where('status', config('const.statusPublished'))->with('user')->with('category')->take(6)->get();

        return view('home', compact('scripts'));
    }
}
