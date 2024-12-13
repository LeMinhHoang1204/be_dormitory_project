@extends('Auth_.index')

<head>
    <title>Request List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="requestlist">
        <h3 class="heading">Requests List</h3>

        <table class="table">
            <thead class="thead">
                <tr>
                    <th>ID</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Resolve Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->sender->name }}</td>
                        <td>{{ $request->receiver->name }}</td>
                        <td>{{ $request->type }}</td>
                        <td>{{ $request->status }}</td>
                        <td>{{ $request->note }}</td>
                        <td>{{ $request->resolve_date ? $request->resolve_date->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    &#x22EE;
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('requests.show', $request->id) }}">View Details</a>
                                    <a class="dropdown-item" href="{{ route('requests.accept', $request->id) }}">Accept</a>
                                    <a class="dropdown-item" href="{{ route('requests.decline', $request->id) }}">Decline</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No requests found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $requests->links() }}
    </div>
@endsection

<style>
    body {
        background-color: #f9fafc;
        font-family: "Poppins", sans-serif;
    }

    .requestlist {
        max-width: 70%;
        margin: 40px auto;
        padding: 30px;
        background-color: #f9f9f9;
        box-shadow: 0px 6px 4px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
    }

    .heading {
        font-family: Inter;
        color: #0e3b9c;
        font-size: 36px;
        font-weight: 700;
        text-align: center;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        color: #ECEFFF;
        border-collapse: collapse;
        border-radius: 20px;
    }

    .table thead {
        background-color: #ECEFFF;
        border-radius: 20px 20px 0px 0px;
    }

    th, td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
</style>
