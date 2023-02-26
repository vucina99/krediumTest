@extends('content')


@section('content')
    <div class="setHeight">
        <div class="padding-start">
            <div class="position-center">
                <div class="two-button">

                    <div class="goback">
                        <a href="/"> GO BACK </a>
                    </div>

                </div>
            </div>
            <br>

            <div class="table">

                <table>
                    <thead>
                    <tr>
                        <th>Product Type</th>
                        <th>Product Value</th>
                        <th>Creation date</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{$report->type}}</td>
                            @if($report->type == 'cash loan')
                            <td>{{$report->loan_amount}}</td>

                            @else
                                <td>{{$report->loan_amount}} - {{$report->down_payment_amount}}</td>
                            @endif
                            <td>{{$report->created_at}}</td>

                        </tr>
                    @endforeach
                    @if(count($reports) < 1)
                        <tr>
                            <td colspan="3" align="center">No results</td>
                        </tr>

                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
