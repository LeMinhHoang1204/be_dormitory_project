@extends('Auth_.index')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('./css/payment.css') }}" type="text/css">
    <script src="{{ asset('./payment.js') }}"></script>
</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="container mt-5">
        <h1>Check In Request</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Residence ID</th>
                <th scope="col">Dorm ID</th>
                <th scope="col">Name</th>
                <th scope="col">Room</th>
                <th scope="col">Member Count</th>
                <th scope="col">Start Date</th>
                <th scope="col">Status</th>
                <th scope="col">Task</th>
            </tr>
            </thead>
            <tbody>
                @if($residences)
                    @foreach ($residences as $residence)
                        <tr>
                            <td scope="row">{{ $residence->id }}</td>
                            <td>{{ $residence->student->id }}</td>
                            <td>{{ $residence->student->name }}</td>
                            <td>{{ $residence->room_id }}</td>
                            <td>{{ $residence->room->member_count }}</td>
                            <td>{{ $residence->start_date }}</td>
                            <td>{{ $residence->status }}</td>
                            <td><a href="{{ route('requests.getDetailCheckInReq', $residence->id) }}" class="btn-task">View</a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td align="center" colspan="8">No data found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{$residences ? $residences->links() : ''}}
    </div>

@endsection
