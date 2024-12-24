@extends('Auth_.index')

<head>
    <title>My Violations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/avatar.css') }}" type="text/css">
    <style>
        .student-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info-left,
        .info-right {
            width: 48%;
        }
    </style>
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
            <div class="student-details" style="margin-left: 40px">
                <div class="info-left">
            <p><strong>Complaint ID:</strong> {{ $complaint->id }}</p>
            <p><strong>Complaint :</strong> {{ $complaint->complaint_description }}</p>
                    <p><strong>Student:</strong>
                        {{ $complaint->student->name }} (ID: {{ $complaint->student->id }})</p>
                    <p><strong>Updated At:</strong>
                        {{ $complaint->updated_at }}</p>
                </div>
                <div class="info-right">
                    <p><strong>Violation:</strong> #{{ $complaint->violation->id }} - {{ $complaint->violation->title }}</p>
                    <p><strong>Status:</strong> {{ $complaint->status }}</p>

            <p><strong>Creator Vio:</strong>
                {{ $complaint->creator->name }} (ID: {{ $complaint->creator->id }})</p>


                </div>
        </div>

            <a href="{{ route('violations.my') }}" class="btn btn-primary" style="margin-left: 40px">Back to Violation</a>
    </div>
@endsection
