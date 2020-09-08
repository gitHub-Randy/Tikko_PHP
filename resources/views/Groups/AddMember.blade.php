@extends('layouts.app')
@section('content')

    <h2>{{ __('Adding people') }}</h2>
    <button type="button" class="btn-success" onclick="window.location='{{ route('groups.index') }}'">{{ __('Back') }}</button>

    <label for="targets">{{ __('Group members') }}: </label>
    <ul id="sendListUl">
        @for(  $i = 0; $i < sizeof($addedUsers); $i++)
            <form action="{{ route('members.delete') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$addedUsers[$i]->id}}">
                <li>{{$addedUsers[$i]->name}}</li>
            </form>
        @endfor
    </ul>

    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="{{ __('Search for names') }}..." title="{{ __('Type a name') }}">
    <ul id="myUL">
        @foreach($users as $u)

            <form action="{{ route('members.store') }}" method="post">
                @csrf
                <input type="hidden" name="group_id" value="{{$group_id}}">
                <input type="hidden" name="user_id" value="{{$u->id}}">
                <li><button type="submit" name="user_name" class="btn btn-primary">{{ $u->name }}</button></li>
            </form>
        @endforeach
    </ul>
    <label for="target"></label>


    <script>
        function addToSendList(){
            var rules = "";

            var w1 = document.getElementById('inputw1').value;
            var w2 = document.getElementById('inputw2').value;
            var w = w1+'-->'+w2;
            var li = document.createElement("li");
            var rule = document.createTextNode(w);
            li.appendChild(rule);

            var removeBtn = document.createElement("input");
            removeBtn.type = "button";
            removeBtn.value = "Remove";
            removeBtn.onclick = remove;
            li.appendChild(removeBtn);
            document.getElementById("list").appendChild(li);

        }


        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("button")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>

@endsection

