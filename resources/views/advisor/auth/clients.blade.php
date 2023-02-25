@extends('content')


@section('content')
    <div class="setHeight">
        <div class="padding-start">
            <div class="position-center">
            <div class="two-button">

                <div class="goback">
                    <a href="/">  GO BACK </a>
                </div>
                <div class="create">
                    <a href="/advisor/create/client"> CREATE</a>
                </div>
            </div>
            </div>
            <br>
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
                    <tr>
                        <td>Marko</td>
                        <td>Markovic</td>
                        <td>30</td>
                        <td>Marko</td>
                        <td>Markovic</td>
                        <td>30</td>
                        <td class="last-td">
                            <div><i class="fa fa fa-pencil"
                                    aria-hidden="true"></i></div>
                            <div><a href=""><i class="fa fa fa-trash"
                                               aria-hidden="true"></i></a></div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
