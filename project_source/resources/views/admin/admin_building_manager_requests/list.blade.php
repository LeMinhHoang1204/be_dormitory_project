@extends('Auth_.index')

<head>
    <title>Request List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/table.css') }}" type="text/css">
<style>
    .extension{
        max-width: 67%;
    }
</style>
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">
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

