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

    <h3>Complaint for Violation #{{ $violation->id }}</h3>

    <form action="{{ route('complaints.store') }}" method="POST">
        @csrf
        <input type="hidden" name="violation_id" value="{{ $violation->id }}">

        <label for="complaint_description">Complaint Description:</label>
        <textarea name="complaint_description" required></textarea>

        <button type="submit">Submit Complaint</button>
    </form>
    </div>
@endsection
