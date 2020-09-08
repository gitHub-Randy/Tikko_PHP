<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Note;
use App\Payment;
use App\Tikko;
use Auth;
use Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class BankAccountController extends Controller
{


    public function addAccount()
    {
        return view('bankAccount.AddBankAccount');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
            'account_number' => 'required',
            ]
        );
        $acc = new BankAccount(
            [
            'account_number' => Crypt::encrypt($request->get('account_number')),
            'user_id' => Auth::id(),
            'balance' => number_format(100.00, 2),

        ]
        );
        $acc->save();
        return $this->index();
    }

    public function index()
    {
        $id = Auth::id();
        $userId = Auth::id();
        $account = BankAccount::select('account_id')->where('user_id', $userId)->get();
        $BankAccount = BankAccount::findmany($account)->where('user_id', '=', $userId);

        foreach ($BankAccount as $b) {
            $b->account_number = Crypt::decrypt($b->account_number);

        }

        $acc = json_decode($BankAccount);
        return view('bankAccount.bankaccounts')->with("accounts", $acc);
    }

    public function show($id)
    {
        $acc = BankAccount::find($id);
        $tikkos = Tikko::select('tikkos.id AS tikko_id', 'tikkos.name AS tikko_name', 'tikkos.currency AS tikko_currency', 'users.name AS user_name', 'payments.tikko_id AS payment_tikkoId', 'payments.payer_id AS payment_payerId', 'payments.payed AS isPayed', 'tikkos.amount AS amount', 'payments.updated_at AS date', 'note.note AS note')
            ->join('payments', 'payments.tikko_id',  'tikkos.id')
            ->join('users', 'users.id',  'payments.payer_id')
            ->join('note', 'note.tikko_id', 'tikkos.id')
            ->where('payments.payed', 1)->where('tikkos.account_id', $acc->account_id)
            ->get();

        return view('bankAccount.viewBankAccount', compact('tikkos', 'acc'));
    }


    public function edit($id)
    {
        $account = BankAccount::find($id);

        $account->account_number = Crypt::decrypt($account->account_number);


        return view('bankAccount.editBankAccount', compact('account'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
            'account_number' => 'required',
            ]
        );

        $account = BankAccount::find($id);
        $account->account_number = Crypt::encrypt($request->get('account_number'));

        $account->save();

        return $this->index();
    }

    public function destroy($id)
    {

        $account = BankAccount::find($id);

        if ($account != null) {
            $account->delete();

        }
        return $this->index();
    }


}
