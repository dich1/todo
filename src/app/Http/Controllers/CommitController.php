<?php 
namespace App\Http\Controllers;

use App\Http\Requests;
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
    public function store(Request $request)
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
    public function update(Request $request, $id)
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
            }
        }
        foreach ($statusies as $key => $status) {
            if (is_null($commitGroupIds[$key])) {
                unset($priorities[$key]);
                unset($statusies[$key]);
                unset($contents[$key]);
            }
        }
        $this->setPriorities($commit, $priorities);
        $this->setStatusies($commit, $statusies);
        $this->setContents($commit, $contents);
        
        $commit->push();
        $commit = Commit::find($id);
        $commit->commitGroups()->saveMany($commitGroups);

        return redirect()->route('commits.show', $id);
    }

    private function setPriorities($commit, $priorities)
    {
        $key = 0;
        foreach ($priorities as $priority) {
            $commit->commitGroups[$key]->priority = $priority;
        }
    }

    private function setStatusies($commit, $statusies)
    {
        $key = 0;
        foreach ($statusies as $status) {
            $commit->commitGroups[$key]->status = $status;
            $key += 1;
        }
    }

    private function setContents($commit, $contents)
    {
        $key = 0;
        foreach ($contents as $content) {
            $commit->commitGroups[$key]->content = $content;
        }
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
