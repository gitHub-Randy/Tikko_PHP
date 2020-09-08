@extends('layouts.app')

@section('content')
<h2>{{ __('Bank Accounts') }}</h2>
    <button type="button" class="btn-success" onclick="window.location='{{ url("/bankaccounts/add") }}'"> {{ __('New bank account') }}</button>

@foreach($accounts as $a)
        <div class="card" style="width: 18rem;">

            <div class="card-body">
                <h5 class="card-title">{{__('Balance')}}: {{$a->balance}} &euro;</h5>
                <p class="card-text">{{ __('Bank number') }}: {{$a->account_number}}<br>
                <a href="{{ route('bankaccounts.edit',$a->account_id)}}" class="btn btn-primary">{{ __('Edit') }}</a>
                <a href="{{ route('bankaccounts.show',$a->account_id)}}" class="btn btn-primary">{{ __('Details') }}</a>

                <form action="{{ route('bankaccounts.destroy', $a->account_id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>

    @endforeach
@endsection
