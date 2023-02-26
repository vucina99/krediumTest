@extends('content')


@section('content')
    <div class="setHeight">
        <div class="login-container">
            @if(session('success'))
                <div class="alert success">
                    <span class="alert-message">{{ session('success') }}</span>
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
            <h2>Edit Client</h2>

            <div class="position-center">

                <div class="two-button">

                    <div class="goback2">
                        <a href="/advisor/clients"> GO BACK</a>

                    </div>

                </div>
            </div>
            <br><br>
            {{--            EDIT CLIENT--}}
            <form action="/advisor/edit/client/{{$client->id}}" method="post">
                @method('PATCH')

                @csrf
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" value="{{$client->first_name}}" name="first_name"
                       placeholder="Enter your First Name">

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" value="{{$client->last_name}}" name="last_name"
                       placeholder="Enter your Last Name">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{$client->email}}" placeholder="Enter your email">

                <label for="phone">Phone:</label>
                <input type="number" id="phone" value="{{$client->phone_number}}" name="phone"
                       placeholder="Enter your phone">

                <button type="submit">Edit Client</button>
            </form>

            {{--            CASH LOAN --}}
            <br><br>
            <div style="width: 100% ; border-bottom: 2px solid #ffffff; height: 10px;"></div>
            <br><br>
            <h2>Cash Loan </h2>

            <form action="/advisor/cash/loan/{{$client->id}}" method="post">
                @method('PATCH')

                @csrf
                <label for="value">Loan Amount:</label>
                <input type="number" id="loan_amount" name="loan_amount" value="{{$client->cashLoan ? $client->cashLoan->loan_amount : 0}}"  placeholder="Loan amount">


                <button type="submit">ACCEPT VALUE</button>
            </form>

            {{--            HOME LOAN--}}


            <br><br>
            <div style="width: 100% ; border-bottom: 2px solid #ffffff; height: 10px;"></div>
            <br><br>
            <h2>Home Loan</h2>

            <form action="/advisor/home/loan/{{$client->id}}" method="post">
                @method('PATCH')
                @csrf
                <label for="value">Down payment amount:</label>
                <input type="number" id="value" value="{{$client->homeLoan ? $client->homeLoan->down_payment_amount : 0}}"  name="down_payment_amount" placeholder="Down payment amount">

                <label for="property_value">Property Value:</label>
                <input type="number" id="property_value" value="{{$client->homeLoan ? $client->homeLoan->property_value : 0}}" name="property_value" placeholder="Property Value">

                <button type="submit">ACCEPT VALUE</button>
            </form>


        </div>
    </div>
    <br><br><br><br><br><br>
@endsection
