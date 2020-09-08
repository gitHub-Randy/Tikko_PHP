@extends('layouts.app')
@section('content')

<h2>{{ __('Bank Accounts') }}</h2>
<button type="button" class="btn-success" onclick="window.location='{{ url("/bankaccounts") }}'">{{ __('Back') }}</button>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
@endif
<form action="{{ route('tikko.add') }}" method="post">
    @csrf
    <label for="title">{{ __('Name') }}</label>
    <input type="text" class="form-control" name="title" placeholder="Tikko {{ __('Name') }}">
        <div class="form-group">
        <label for="amount">{{ __('Amount') }}</label>
        <input type="text" class="form-control" name="amount" placeholder="00.00">
    </div>
    <label for="bankRekening">{{ __('Bank Accounts') }}</label>
    <select class="form-control" name="bankRekening">
        @foreach($num as $b)
            <option>{{$b->account_number}}</option>
        @endforeach
    </select>
    <label for="valuta">{{ __('Currency') }}</label>
    <select class="form-control" name="valuta">
        <option value="EUR" selected>{{ __('Euro') }}</option>
        <option value="GBP">{{ __('British Pound') }}</option>
        <option value="USD">{{ __('United States Dollar') }}</option>
    </select>

    <label for="date">{{ __('Date') }}</label>

    <input class="date form-control" type="text" name="date">
    <label for="description">{{ __('Description') }}</label>

    <input class="form-control"  type="text" name="description">

    <input type="hidden" name="l" value="{{ config('app.locale') }}">
    <button type="submit" class="btn btn-primary" name="submit" value="TikkoOne">{{ __('Send Tikko to 1 person') }}</button>
    <button type="submit" class="btn btn-primary" name="submit" value="TikkoGroup">{{ __('Send Tikko to group') }}</button>
</form>














@endsection
