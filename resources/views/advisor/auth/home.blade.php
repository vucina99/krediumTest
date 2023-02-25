@extends('content')


@section('content')
    <div class="setHeight">
        <div class="container-welcome">
            <div>
                <h1>WELCOME  - {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h1>
            </div>
        </div>
    </div>
@endsection
