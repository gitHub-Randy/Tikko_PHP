<?php

namespace App\Http\Controllers;

use App\GroupMember;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        $group_member = new GroupMember(
            [
            'group_id'=> $request->group_id,
            'user_id' => $request->user_id,
            ]
        );
        $group_member->save();
        return $this->edit($request->group_id);
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
        $users = User::where('id', '!=', Auth::id())->get();
        $group_id = $id;

            $groupMembers = GroupMember::where('group_id', $group_id)->get();
            $addedUsers = array();
        for($i = 0; $i < sizeof($groupMembers); $i++){
            $userToAdd = User::where('id', $groupMembers[$i]->user_id)->first();
            $addedUsers[$i] = $userToAdd ;
        }

        return view('Groups.AddMember', compact('users', 'group_id',  'addedUsers'));

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
        $group = Group::find($request);

        if ($group != null) {
            $group->delete();

        }
        return view('groups.index');
    }
}
