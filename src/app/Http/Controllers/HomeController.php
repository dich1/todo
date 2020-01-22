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
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::with('commits')->findOrFail(Auth::user()->id);

        $currentCommitsQuery = $user->commits()
                                ->whereDate('limit', '>=', date('Y-m-d'));
        $currentCommits = $currentCommitsQuery
                                ->orderBy('limit', 'asc')
                                ->limit(100)
                                ->get();
        $currentCommitsCount = $currentCommitsQuery->count();

        $previousCommitsQuery = $user->commits()
                                ->whereDate('limit', '<', date('Y-m-d'));
        $previousCommits = $previousCommitsQuery
                                ->orderBy('limit', 'desc')
                                ->limit(100)
                                ->get();
        $previousCommitsCount = $previousCommitsQuery->count();

        return view('auth.mypage', compact(
                'currentCommits',
                'previousCommits',
                'currentCommitsCount',
                'previousCommitsCount'
            )
        );
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

    /**
     *  [API] 「もっと見る」押下時のコミットデータを取得する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMoreCommit(Request $request)
    {
        // current or previous
        $type = $request->get('type');
        // 現状表示されている数 (= スキップする数)
        $skip = $request->get('skip');
        // リクエストが不正な場合は400 error
        if (is_null($type) || is_null($skip)) {
            return response()->json(['status' => 'NG'], 400);
        }

        $user = User::with('commits')->findOrFail(Auth::user()->id);
        // 日付の比較オペレータ
        $operator = $type === 'current' ? '>=' : '<';
        // 期日のソート
        $sort = $type === 'current' ? 'asc' : 'desc';
        $query = $user
                    ->commits()
                    ->whereDate('limit', $operator, date('Y-m-d'));
        $total = $query->count();
        // さらに読み込むコミットを2件まで取得
        $commits = $query
                    ->skip($skip)
                    ->limit(2)
                    ->orderBy('limit', $sort)
                    ->get();

        // データがない場合は404 error
        if (count($commits) === 0) {
            return response()->json(['status' => 'NG'], 404);
        }

        $response = [
            'status' => 'OK',
            'commits' => $commits,
            'isMore' => $skip + $commits->count() < $total,
            'currentCount' => $skip + $commits->count(),
            'totalCount' => $total,
        ];
        return response()->json($response, 200);
    }
}
