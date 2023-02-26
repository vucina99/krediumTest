@extends('content')


@section('content')
    <div class="setHeight">
        <div class="padding-start">
            <div class="position-center">
                <div class="two-button">

                    <div class="goback">
                        <a href="/"> GO BACK </a>
                    </div>
                    <div class="create">
                        <a href="/advisor/create/client"> CREATE</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="table">
                @if(session('success'))
                    <div class="alert success">
                        <span class="alert-message">{{ session('success') }}</span>
                    </div>
                @endif
            </div>
            <div class="table">

                <table>
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>E-mail</th>
                        <th>Phone</th>
                        <th>Cash Loans</th>
                        <th>Home Loans</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{$client->first_name}}</td>
                            <td>{{$client->last_name}}</td>
                            <td>{{$client->email}}</td>
                            <td>{{$client->phone_number}}</td>
                            <td>{{$client->cashLoan ? 'YES' : 'NO'}}</td>
                            <td>{{$client->homeLoan ? 'YES' : 'NO'}}</td>
                            <td class="last-td">
                                <div><a href="/advisor/edit/client/{{$client->id}}"><i class="fa fa fa-pencil"
                                                                                       aria-hidden="true"></i></a></div>
                                <div>
                                    <form action="/advisor/delete/client/{{$client->id}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button><i class="fa fa fa-trash"
                                                   aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($clients) < 1)
                        <tr>
                            <td colspan="7" align="center">No results</td>
                        </tr>

                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
