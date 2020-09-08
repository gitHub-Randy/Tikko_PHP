@extends('layouts.app')
@section('content')

    <h2>{{ __('Made Tikkos') }}</h2>
    @foreach($tikkos as $t)
    <div class="card">
        <div class="card-header">{{ $t->name }}</div>
        <div class="card-body">
            <strong>{{ __('Note') }}: </strong>{{$t->description}}<br>
            <strong>{{ __('Currency') }}: </strong>{{$t->currency}}<br>
            <strong>{{ __('Amount') }}: </strong>{{$t->amount}}<br>
            <strong>{{ __('Date') }}: </strong>{{$t->tikko_date}}<br>
        </div>
        <div class="card-footer">
            <form action="{{ route('tikko.destroy', $t->id)}}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="tikko_id" value="{{$t->id}}">
                <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
            </form>
        </div>
    </div><br>
    @endforeach




@endsection
