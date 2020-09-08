<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Group;
use App\GroupMember;
use App\Payment;
use App\Tikko;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class SentjesController extends Controller
{


    public function showTikkos()
    {

        $u_id = Auth::id();
        $tikkos = Tikko::where('user_id', $u_id)->get();
        foreach ($tikkos as $tikko) {
            $tempdate = new \DateTime($tikko->tikko_date);
            if (App::getLocale() === 'en') {
                $tikko->tikko_date = $tempdate->format('m-d-Y');
                $tikko->amount =  number_format($tikko->amount ,2,".",",");

            } else {
                $tikko->tikko_date = $tempdate->format('d-m-Y');
                $tikko->amount =  number_format($tikko->amount ,2,",",".");

            }
        }
        return view('Tikkos.tikkoOverview', compact('tikkos'));
    }

    public function addTikko(Request $request)
    {

         $request->validate(
        [
            'title' => 'required',
            'description' => 'required',
            'amount' =>'required|numeric',
            'valuta' =>'required',
            'date' => 'required|date',
        ]
    );
        $u_id = Auth::id();
        $acc_id = 0;
        $accs = BankAccount::where('user_id', $u_id)->get();
        foreach ($accs as $a) {

            $decrypt = Crypt::decrypt($a->account_number);

            if ($decrypt == $request->bankRekening) {
                $acc_id = $a->account_id;
            }
        }

        $originalDate = $request->date;
        $newDate = null;
        $newDate = date("Y/m/d", strtotime($originalDate));



        $tikko = new Tikko(
            [
            'user_id' => Auth::id(),
            'name' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->valuta,
            'account_id' => $acc_id,
            'tikko_date' => $newDate,
            ]
        );

                $tikko->save();
                $newTikko = Tikko::orderBy('created_at', 'desc')->first();
                $users = User::all();

                $personSended =array( " ");
        if($request->submit == 'TikkoGroup') {
            $groups = Group::where('user_id', Auth::id())->get();

            return view('Tikkos.finalizeGroupTikko', compact('newTikko', 'groups'));

        }else{
            return view('Tikkos.finaliseSentje', compact('newTikko', 'users', 'personSended'));

        }



    }


    public function groupStore(Request $request)
    {
        $group_members = GroupMember::where('group_id', $request->group_id)->get();
        foreach ($group_members as $gM){
            $payment = new Payment(
                [
                'tikko_id' => $request->tikko_id,
                'payer_id' => $gM->user_id,
                'payed' => 0,
                ]
            );
            $payment->save();

        }

        return view('home');
    }



    public function store(Request $request)
    {
        $payments = Payment::all();
        $payer = User::where('name', $request->payer_name)->get();
        //        foreach ($Tikkos as $p){
        //            $t_id = $p->tikko_id;
        //            $p_id = $p->payer_id;
        //
        //                if($request->tikko_id == $t_id && $payer[0]->id == $p_id){
        //
        //
        //                    $newTikko = Tikko::all()->last();
        //                    $users = User::all();
        //                    $pId = $payer[0]->id;
        //                    $u = User::where('id',$pId)->get();
        //                    $personSended = array($u[0]->name);
        ////                    \Session::flash('error', 'Deze gebruiker heeft deze tikko al gestuurd gekregen');
        //                    return view('Tikkos.finaliseSentje',compact('newTikko', 'users', 'personSended'));
        //
        //                }
        //
        //        }
        $payment = new Payment(
            [
                'tikko_id' => $request->tikko_id,
                'payer_id' => $payer[0]->id,
                'payed' => 0,

            ]
        );

        $payment->save();

        $lastPays = Payment::where('tikko_id', 'like', $request->tikko_id)->get();
        $sendTikkoUserIds = array();
        $personSended = array();
        foreach ($lastPays as $tik){
            array_push($sendTikkoUserIds, $tik->payer_id);
            $payerName = User::where('id', $tik->payer_id)->get();
            array_push($personSended, $payerName[0]->name);


        }




        $newTikko = Tikko::orderBy('created_at', 'desc')->first();
        if (App::getLocale() === 'en') {
            $newTikko->amount = number_format($newTikko->amount, 2, '.', ',');
        } else {
            $newTikko->amount = number_format($newTikko->amount, 2, ',', '.');
        }
        $users = User::all();

        $pId = $payer[0]->id;
        $u = User::where('id', $pId)->get();

        return view('Tikkos.finaliseSentje', compact('newTikko', 'users', 'personSended'));


    }

    public
    function show($id)
    {
        return view('bankAccount.viewBankAccount');
    }

    public
    function edit($id)
    {
        $account = BankAccount::find($id);

        $account->bank_number = Crypt::decrypt($account->bank_number);
        $account->bank_name = Crypt::decrypt($account->bank_name);

        return view('bankAccount.editBankAccount', compact('account'));
    }

    public
    function update(Request $request, $id)
    {
        $request->validate(
            [
            'bank_name' => 'required',
            'bank_number' => 'required',
            ]
        );

        $account = BankAccount::find($id);
        $account->bank_name = Crypt::encrypt($request->get('bank_name'));
        $account->bank_number = Crypt::encrypt($request->get('bank_number'));
        $account->save();

        return $this->index();
    }

    public function index()
    {
        $id = Auth::id();
        $num = BankAccount::where('user_id', $id)->get();
        foreach ($num as $n) {
            $n->account_number = Crypt::decrypt($n->account_number);

        }
        $num2 = BankAccount::where('user_id', $id)->get();
        return view('Tikkos.makeSentje', compact('num', 'num2'));
    }

    public
    function destroy($id)
    {
        $tikko = Tikko::where('id', $id)->first();

        $payments = Payment::where('tikko_id', $tikko->id)->get();
        $isTikkoPaid = false;
        foreach ($payments as $p){
            if($p->payed == '1') {
                $isTikkoPaid = true;
            }
        }
        if($isTikkoPaid == false) {
            foreach ($payments as $p){
                $payment = Payment::where('tikko_id', $p->tikko_id)->where('payer_id', $p->payer_id)->get()->delete();
            }
            $tikko->delete();
        }



        return $this->showTikkos();
    }

    //    public function store(Request $request)
    //    {
    //        $payer = User::where('name', $request->payer_name)->get();
    //
    //        $payment = new Payment([
    //                'tikko_id' => $request->tikko_id,
    //                'payer_id' => $payer[0]->id,
    //                'payed' => 0,
    //
    //            ]
    //        );
    //
    //        $payment->save();
    //
    //        $lastPays = Payment::where('tikko_id', 'like', $request->tikko_id)->get();
    //        $sendTikkoUserIds = array();
    //        $personSended = array();
    //        foreach ($lastPays as $tik) {
    //            array_push($sendTikkoUserIds, $tik->payer_id);
    //            $payerName = User::where('id', $tik->payer_id)->get();
    //            array_push($personSended, $payerName[0]->name);
    //        }
    //
    //        $newTikko = Tikko::orderBy('created_at', 'desc')->first();
    //        $users = User::whereNotIn('id', $sendTikkoUserIds)->get();
    //
    //        $pId = $payer[0]->id;
    //        $u = User::where('id', $pId)->get();
    //        return view('Tikkos.finaliseSentje', compact('newTikko', 'users', 'personSended'));
    //    }


}
