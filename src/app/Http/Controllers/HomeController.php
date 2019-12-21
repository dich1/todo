<?php

namespace App\Http\Controllers;

use App\Commit;
use App\CommitGroup;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $currentCommits = $user->commits()
                               ->whereDate('limit', '>=', date('Y-m-d'))
                               ->orderBy('limit', 'asc')
                               ->paginate(100);
        $previousCommits = $user->commits()
                                ->whereDate('limit', '<', date('Y-m-d'))
                                ->orderBy('limit', 'desc')
                                ->paginate(100);
        
        return view('auth.mypage', compact('currentCommits', 'previousCommits'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validator($request->all())->validate();
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        if (!is_null($request->input("password"))) {
            $user->password = bcrypt($request->input("password"));
        }
        $user->save();
        
        return redirect()->route('home')->with('message', 'ユーザー情報を更新しました。');
    }

    public function unsubscribe(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([], 204);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255'],
        ]);
    }
}
