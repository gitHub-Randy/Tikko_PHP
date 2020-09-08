@extends('layouts.app')
@section('content')

    <h2>{{ __('Group') }} Tikko</h2>
    <button type="button" class="btn-success" onclick="window.location='{{ url("/bankaccounts") }}'">{{ __('Back') }}</button>

    <div class="card">
        <div class="card-header">{{ $newTikko->name }}</div>
        <div class="card-body">
            <strong>{{ __('Note') }}: </strong>{{$newTikko->description}}<br>
            <strong>{{ __('Currency') }}: </strong>{{$newTikko->currency}}<br>
            <strong>{{ __('Amount') }}: </strong>{{$newTikko->amount}}<br>
            <strong>{{ __('Date') }}: </strong>{{$newTikko->tikko_date}}<br>
        </div>
    </div>



    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="{{ __('Search for names') }}..." title="{{ __('Type a name') }}">
    <ul id="myUL">
        @foreach($groups as $g)
            <form action="{{ route('tikko.groupStore') }}" method="post">
                @csrf
                <input type="hidden" name="tikko_id" value="{{$newTikko->id}}">
                <input type="hidden" name="group_id" value="{{$g->id}}">
                <li><button type="submit" class="btn btn-primary">{{ $g->name }}</button></li>
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
