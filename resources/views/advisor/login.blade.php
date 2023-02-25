@extends('content')


@section('content')
    <div class="setHeight">
        <div class="login-container">
            <h2>Login</h2>
            <form action="/login" method="post">
                @csrf
                @if($errors->has('email'))
                    <div class="alert danger">
                        <span class="alert-message"> {{ $errors->first('email') }} </span>
                    </div>
                @endif
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection
