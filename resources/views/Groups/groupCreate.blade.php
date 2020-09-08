@extends('layouts.app')
@section('content')

    <h2>{{ __('Groups') }}</h2>
    <button type="button" class="btn-success" onclick="window.location='{{ route('groups.index') }}'">{{ __('Back') }}</button>
    <div class="card uper">
        <div class="card-header">
            {{ __('Adding group') }}
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('groups.store') }}">
                <div class="form-group">
                    @csrf
                    <input type="text" class="form-control" name="group_name"/>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
            </form>
        </div>
    </div>
@endsection


