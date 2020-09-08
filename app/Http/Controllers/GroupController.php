<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMember;
use Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('Groups.groupCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'group_name' => 'required',
            ]
        );
        $group = new Group(
            [
            'name' => $request->group_name,
            'user_id' => Auth::id(),
            ]
        );
        $group->save();
        return $this->index();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myGroups = Group::where('user_id', Auth::id())->get();
        return view('Groups.groupOverview')->with("groups", $myGroups);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $group = Group::find($request->id);

        if ($group != null) {
            $group->delete();

        }
        return $this->index();
    }
}
