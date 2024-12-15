@extends('Auth_.index')

<head>
    <title>Your Room Information</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">

</head>

@section('content')
    @include('layouts.sidebar_student') <!-- Sidebar giống với extension -->

    <div class="extension">
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
        <h3 class="heading">My Room Information</h3>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
{{--            @if(!$residence)--}}
{{--                <p>No room information available at the moment.</p>--}}
{{--            @else--}}
        <!-- Thông tin phòng -->
        <div class="current-room-info">
            <h5 class="section-title">Room Details</h5>
            <p><strong>Room Name:</strong> {{ isset($residence) ? $residence->room->name : 'Room 101' }}</p>
            <p><strong>Building:</strong> {{ isset($residence) ? $residence->room->building->build_name : 'Building A' }}</p>
            <p><strong>Start Date:</strong> {{isset($residence) ? \Carbon\Carbon::parse($residence->start_date)->format('d-m-Y') : '01-12-2023'  }}</p>
            <p><strong>End Date:</strong> {{isset($residence) ? \Carbon\Carbon::parse($residence->end_date)->format('d-m-Y') : '01-12-2024'}}</p>
            <p><strong>Status:</strong> {{ isset($residence) ? $residence->status :'' }}</p>
        </div>

        <div class="section" style="align-content: space-between">
            <button class="grey-btn" onclick="window.location.href='{{ route('dashboard') }}'">< Back</button>

            <button class="blue-btn" onclick="alert('Action Completed')">Extend</button>
        </div>
{{--            @endif--}}
        @if(isset($message))
            <div class="message-alert">
                {{ $message }}
            </div>
        @endif
    </div>
@endsection

