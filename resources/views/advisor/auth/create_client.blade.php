@extends('content')


@section('content')
    <div class="setHeight">
        <div class="login-container">
            <h2>Create Client</h2>
            <br>
            @if(session('success'))
                <div class="alert success">
                    <span class="alert-message">  {{ session('success') }} </span>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <span class="alert-message">{{ $error }}</span>
                        @endforeach
                    </ul>
                </div>
            @endif
            <br>
            <form action="/advisor/create/client/system" method="post">
                @csrf
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter your First Name">

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter your Last Name">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">

                <label for="phone">Password:</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone">

                <button type="submit">Create Client</button>
            </form>
        </div>
    </div>
@endsection
