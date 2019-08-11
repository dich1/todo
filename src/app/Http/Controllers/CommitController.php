<?php 
namespace App\Http\Controllers;

use App\Http\Requests\CommitRequest;
use App\Http\Controllers\Controller;

use App\Commit;
use App\CommitGroup;
use Auth;
use DateTime;
use Illuminate\Http\Request;

class CommitController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $commits = Commit::orderBy('id', 'desc')->paginate(10);

        return view('index', compact('commits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('commits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CommitRequest $request)
    {
        $commit = new Commit();
        $commit->fill($request->all())->save();

        $commitGroups = array();
        $contents = $request->input("content");
        foreach ($contents as $key => $content) {
            if (!empty($content)) {
                $commitGroup = new CommitGroup(['priority' => $key, 'status' => 0, 'content' => $content]);
                $commitGroups[$key] = $commitGroup;
            }
        }
        $commit = Commit::find($commit->id);
        $commit->commitGroups()->saveMany($commitGroups);

        return redirect()->route('commits.show', $commit->id)->with('message', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $commit = Commit::findOrFail($id);
        $commitGroups = Commit::findOrFail($id)->commitGroups()->orderBy('priority')->get();
        $limit = new DateTime($commit->limit);
        $remainingDays = $limit->diff(new DateTime(date('Y-m-d')))->days;
        $counter = 0;
        foreach($commit->commitGroups as $key => $commitGroup) {
            if ($commitGroup->status) {
                $counter += 1;
            }
        }
        $remainingCommits = count($commit->commitGroups) - $counter;
        return view('commits.show', compact('commit', 'commitGroups', 'remainingDays', 'remainingCommits'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $commit = Commit::findOrFail($id);
        $commitGroups = Commit::findOrFail($id)->commitGroups()->orderBy('priority')->get();

        return view('commits.edit', compact('commit', 'commitGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(CommitRequest $request, $id)
    {
        $commit = Commit::findOrFail($id);
        $commit->limit = $request->input("limit");

        $commitGroupIds = $request->input("commit-group-id");
        $contents = $request->input("content");
        $statusies = $request->input("status");
        $priorities = $request->input("priority");

        $commit->status = ($statusies[0] == 1 && count(array_unique($statusies)) == 1) ? 1 : 0;

        $commitGroups = array();
        $commitGroupKey = count(array_filter($commitGroupIds));
        foreach ($statusies as $key => $status) {
            if (is_null($commitGroupIds[$key])) {
                $commitGroup = new CommitGroup([
                    'priority' => $priorities[$key], 
                    'status' => 0, 
                    'content' => $contents[$key]
                ]);
                $commitGroups[$commitGroupKey] = $commitGroup;
                $commitGroupKey++;
                unset($priorities[$key]);
                unset($statusies[$key]);
                unset($contents[$key]);
            }
        }
        $priorities = array_values($priorities);
        $statusies = array_values($statusies);
        $contents = array_values($contents);
        foreach ($statusies as $key => $status) {
            $commit->commitGroups[$key]->priority = $priorities[$key];
            $commit->commitGroups[$key]->status = $statusies[$key];
            $commit->commitGroups[$key]->content = $contents[$key];
        }
        $commit->push();
        $commit = Commit::find($id);
        $commit->commitGroups()->saveMany($commitGroups);

        return redirect()->route('commits.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $commit = Commit::findOrFail($id);
        $commit->delete();

        return response()->json([], 204);
    }

}
