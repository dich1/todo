<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Commit;
use App\CommitGroup;
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

        return view('commits.index', compact('commits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
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
        $commitGroup = new CommitGroup();

        $commitGroup->priority = 1;
        $commitGroup->content = $request->input("content");

        $commit->fill($request->all())->save();
        $commit = Commit::find($commit->id);
        $commit->commitGroups()->save($commitGroup);

        return redirect()->route('commits.index')->with('message', 'Item created successfully.');
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

        return view('commits.show', compact('commit'));
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

        return view('commits.edit', compact('commit'));
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

        $commit->user_id = $request->input("user_id");
        $commit->group_id = $request->input("group_id");
        $commit->limit = $request->input("limit");
        $commit->status = $request->input("status", 0);

        $commit->save();

        return redirect()->route('commits.index')->with('message', 'Item updated successfully.');
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

        return redirect()->route('commits.index')->with('message', 'Item deleted successfully.');
    }

}
