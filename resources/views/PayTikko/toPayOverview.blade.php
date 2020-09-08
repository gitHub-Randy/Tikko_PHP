@extends('layouts.app')
@section('content')

    <h2>{{ __('Tikkos to pay') }}</h2>
        @foreach($tikkos as $t)
             <div class="card">
                <div class="card-header">{{ $t->name }}</div>
                <div class="card-body">
                    <strong>{{ __('Name') }}: </strong>{{$t->t_name}}<br>
                    <strong>{{ __('Valuta') }}: </strong>{{$t->t_curr}}<br>
                    <strong>{{ __('Amount') }}: </strong>{{$t->t_amount}}<br>
                    <strong>{{ __('Date') }}: </strong>{{$t->t_date}}<br>
                    <strong>{{ __('Reciever') }}: </strong>{{$t->u_name}}<br>
                </div>
                <div class="card-footer">
                    <form action="{{ route('preparePayment') }}" method="post">
                        @csrf
                        <input type="hidden" name="tikko_id" value="{{ $t->t_id }}">
                        <input class="btn btn-success" type="submit" value="{{ __('Pay') }}">
                    </form>
                </div>
            </div><br>
        @endforeach
@endsection
