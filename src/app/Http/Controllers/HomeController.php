<?php

namespace App\Http\Controllers;

use App\Commit;
use App\CommitGroup;
use Auth;
use App\User;
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
        $user = User::findOrFail(Auth::user()->id);
        $commits = $user->commits()->orderBy('id', 'desc')->paginate(10);
        
        return view('auth.mypage', compact('commits'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        if (!is_null($request->input("password"))) {
            $user->password = bcrypt($request->input("password"));
        }
        $user->save();
        
        return redirect()->route('home');
    }
}
