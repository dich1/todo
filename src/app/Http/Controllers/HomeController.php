<?php

namespace App\Http\Controllers;

use App\Commit;
use App\CommitGroup;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $commits = Commit::orderBy('id', 'desc')->paginate(10);
        return view('auth.mypage', compact('commits'));
    }
}
