@extends('layouts.app')
@section('content')

    <h2>{{ __('Prepare Payment') }}</h2>
    <button type="button" class="btn-success" onclick="window.location='{{ url("/pay")}}'">{{ __('Back') }}</button>
    <form action="{{ route('prepare') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="title">{{ __('Name') }}</label>
        <input type="text" class="form-control" name="title" value="{{$tikko[0]->name}}" readonly>
        <div class="form-group">
            <label for="amount">{{ __('Amount') }}</label>
            <input type="text" class="form-control" name="amount" value="{{$tikko[0]->amount}}" readonly>
        </div>
        <label for="valuta">{{ __('Currency') }}</label>
        <select class="form-control" name="valuta">
            <option value="EUR" selected>{{ __('Euro') }}</option>
            <option value="GBP">{{ __('Britisch Pound') }}</option>
            <option value="USD">{{ __('United States Dollar') }}</option>
        </select><br>


        <input type="hidden" name="tikko_date" value="01-01-2019">
        <input type="hidden" name="tikko_id" value="{{$tikko[0]->id}}">

        <label for="note">Notitie</label>
        <input type="text" name="note"  class="form-control">
        <br>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </form>




@endsection
