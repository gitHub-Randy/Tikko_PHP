<?php

namespace App\Http\Controllers;

use App\Note;
use App\Payment;
use App\Tikko;
use App\Tikko_photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use danielme85\CConverter\Currency;

class PaymentController extends Controller
{
    public function MollieHook(Request $request)
    {
        $payment = Mollie::api()->payments()->get($request['id']);

        if ($payment->isPaid()) {
            Payment::where("payment_id", "=", $request['id'])->update(['payed' => 1]);
            $p = Payment::where("payment_id", "=", $request['id'])->first();

            $amount = Currency::conv($from = $payment->amount->currency, $to = "EUR", $value = $payment->amount->value, $decimals = 2);
            $acc = $p->tikko->first()->bankaccount;
            $balance = $acc->balance;
            $newBalance = $balance += $amount;
            $newBalance = number_format($newBalance, 2);
            $p->tikko->bankaccount->update(['balance' => $p->tikko->bankaccount->balance = $newBalance]);
            return "Payment received.";
        }
    }

    public function prepare(Request $req)
    {
        $tikko = Tikko::find($req->tikko_id);
        $amount = number_format(Currency::conv($from = $tikko->currency, $to = $req->valuta, $value = $tikko->amount, $decimals = 2), 2);
        $string = "".$amount;
        $payment = Mollie::api()->payments()->create(
            [
            'amount' => [
                'currency' => $req->valuta,
                'value' => $amount
            ],
            'description' => $tikko->description,
            'webhookUrl' => route('payment.webhook'),
            'redirectUrl' => route('home'),
            ]
        );

        $payment = Mollie::api()->payments()->get($payment->id);

        Payment::where('payer_id', Auth::id())->where('tikko_id', $tikko->id)->update(['payment_id' => $payment->id]);
        $note = new Note();
        $note->tikko_id = $tikko->id;
        $note->note = $req->note;
        $note->save();
        return redirect($payment->getCheckoutUrl(), 303);
    }



    public function preparePayment(Request $request)
    {
        $tikko = Tikko::where('id', $request->tikko_id)->get();
        return view('payTikko.preparePayment', compact('tikko'));
    }



}
