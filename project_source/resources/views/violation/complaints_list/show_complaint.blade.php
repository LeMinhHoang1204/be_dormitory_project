@extends('Auth_.index')

<head>
    <title>My Violations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/avatar.css') }}" type="text/css">
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">
        <div class="bluefont"><h3>Complaint Details</h3></div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        <div class="complaint-details">
            <p><strong>Complaint ID:</strong> {{ $complaint->id }}</p>
            <p><strong>Violation:</strong> #{{ $complaint->violation->id }} - {{ $complaint->violation->title }}</p>
            <p><strong>Complaint Description:</strong> {{ $complaint->complaint_description }}</p>
            <p><strong>Status:</strong> {{ $complaint->status }}</p>

            <div>
                <strong>Student:</strong>
                <p>{{ $complaint->student->name }} (ID: {{ $complaint->student->id }})</p>
            </div>

            <div>
                <strong>Creator Violation By:</strong>
                <p>{{ $complaint->creator->name }} (ID: {{ $complaint->creator->id }})</p>
            </div>

            <div>
                <strong>Created At:</strong>
                <p>{{ $complaint->created_at }}</p>
            </div>

            <div>
                <strong>Updated At:</strong>
                <p>{{ $complaint->updated_at }}</p>
            </div>
        </div>

        <a href="{{ route('violations.show', ['id' => $complaint->violation_id]) }}" class="btn btn-primary">Back to Violation</a>
    </div>
@endsection
