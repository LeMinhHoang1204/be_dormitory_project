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

    <div class="bluefont"><h3>Complaint for Violation #{{ $violation->id }}</h3></div>

    <form action="{{ route('complaints.store') }}" method="POST">
        @csrf
        <input type="hidden" name="violation_id" value="{{ $violation->id }}">
<div class="form-label">
        <label for="complaint_description" class="form-label">Complaint Description:</label>
        <textarea name="complaint_description" class="form-textarea" required></textarea>

        <button type="submit" class="form-button">Send</button>
    </div>
    </form>
    </div>
        <style>
        .form-label {
            font-family: 'Poppins', sans-serif;
            width: 100%;
            text-align: center;
            display: block;
            margin-bottom: 10px;
        }

        .form-textarea {
            align-content: center;
            width: 60%;
            max-width: 600px;
            height: 100px;
            margin: 0 auto;
            display: block;
            padding: 10px;
            font-family: 'Poppins', sans-serif;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 10px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .form-button:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
