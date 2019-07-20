<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CommitGroup;
use Illuminate\Http\Request;

class CommitGroupController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $commitGroup = CommitGroup::findOrFail($id);
        $commitGroup->delete();

        return back()->with('message', 'Item deleted successfully.');
    }
}
