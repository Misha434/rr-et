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
        $scripts = Script::with('user')->with('category')->get();

        return view('home', compact('scripts'));
    }
}
