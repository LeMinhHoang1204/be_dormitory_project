@extends('Auth_.index')

<head>
    <title>Your Room Information</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
</head>

@section('content')
    @include('layouts.sidebar_student') <!-- Sidebar giống với extension -->

    <div class="extension">
        <h3 class="heading">Your Room Information</h3>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Thông tin phòng -->
        <div class="current-room-info">
            <h5 class="section-title">Room Details</h5>
            <p><strong>Room Name:</strong> {{ $residence->room->name ?? 'N/A' }}</p>
            <p><strong>Building:</strong> {{ $residence->room->building->name ?? 'N/A' }}</p>
            <p><strong>Start Date:</strong> {{ $residence->start_date->format('d/m/Y') }}</p>
            <p><strong>End Date:</strong> {{ $residence->end_date->format('d/m/Y') }}</p>
            <p><strong>Status:</strong> {{ $residence->status }}</p>
        </div>

        <div class="section">
            <button class="btn-complete" onclick="alert('Action Completed')">Extend</button>
            <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Go Back</button>
        </div>

        @if(isset($message))
            <div class="message-alert">
                {{ $message }}
            </div>
        @endif
    </div>
@endsection
