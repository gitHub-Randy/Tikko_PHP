@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You have successfully logged in!') }}
                        <br><br>
                        <button type="button" onclick="window.location='{{ url("/bankaccounts") }}'">{{ __('Go to bank accounts') }}</button>
                    <br /><br />
                    {{ __('Change the language') }}
                    <div>
                        <button><a class="dropdown-item" href="lang/en" id="en">English</a></button>
                        <button><a class="dropdown-item" href="lang/nl" id="ge">Dutch</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
