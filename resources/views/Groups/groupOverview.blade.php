@extends('layouts.app')
@section('content')
    <h2>{{ __('Groups') }}</h2>
    <button type="button" class="btn-success" onclick="window.location='{{ route('groups.create') }}'">{{ __('New group') }}</button>
        @foreach($groups as $g)
            <div class="card" style="width: 18rem;">

                <div class="card-body">
                    <h5 class="card-title">{{ __('Group name') }}: {{$g->name}}</h5>
                        <a href="{{ route('members.edit',$g->id)}}" class="btn btn-primary">{{ __('Show more') }}</a>
                    <form action="{{ route('groups.destroy', $g->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{$g->id}}">
                        <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        @endforeach
@endsection
