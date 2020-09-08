<?php

namespace App\Http\Controllers;

use App\Tikko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();

        $tikkos = Tikko::select('tikkos.id AS t_id', 'tikkos.name AS t_name', 'tikkos.currency AS t_curr', 'tikkos.amount AS t_amount', 'users.name AS u_name', 'payments.tikko_id AS p_tId', 'payments.payer_id AS p_pId', 'tikkos.tikko_date AS t_date')
            ->join('payments', 'payments.tikko_id', '=', 'tikkos.id')
            ->join('users', 'users.id', '=', 'tikkos.user_id')
            ->where('payments.payer_id', $userId)
            ->where('payments.payed', 0)
            ->get();


        return view('PayTikko.toPayOverview', compact('tikkos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
