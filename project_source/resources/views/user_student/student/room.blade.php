{{--@extends('Auth_.index')--}}

{{--<head>--}}
{{--    <title>Your Room Information</title>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">--}}
{{--</head>--}}

{{--@section('content')--}}
{{--    @include('layouts.sidebar_student') <!-- Sidebar giống với extension -->--}}

{{--    <div class="extension">--}}
{{--        @if (session('success'))--}}
{{--            <div class="alert alert-success">--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        @if (session('error'))--}}
{{--            <div class="alert alert-error">--}}
{{--                {{ session('error') }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <h3 class="heading">My Room Information</h3>--}}

{{--        @if(session('error'))--}}
{{--            <div class="alert alert-danger">--}}
{{--                {{ session('error') }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--            @if(!$residence)--}}
{{--                <p>No room information available at the moment.</p>--}}
{{--            @else--}}
{{--        <!-- Thông tin phòng -->--}}
{{--        <div class="current-room-info">--}}
{{--            <h5 class="section-title">Room Details</h5>--}}
{{--            <p><strong>Room Name:</strong> {{ $residence->room->name ?? 'N/A' }}</p>--}}
{{--            <p><strong>Building:</strong> {{ $residence->room->building->build_name ?? 'N/A' }}</p>--}}
{{--            <p><strong>Start Date:</strong> {{ $residence->start_date->format('d/m/Y') }}</p>--}}
{{--            <p><strong>End Date:</strong> {{ $residence->end_date->format('d/m/Y') }}</p>--}}
{{--            <p><strong>Status:</strong> {{ $residence->status }}</p>--}}
{{--        </div>--}}

{{--        <div class="section">--}}
{{--            <button class="btn-complete" onclick="alert('Action Completed')">Extend</button>--}}
{{--            <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Go Back</button>--}}
{{--        </div>--}}
{{--            @endif--}}
{{--        @if(isset($message))--}}
{{--            <div class="message-alert">--}}
{{--                {{ $message }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endsection--}}


@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Room</h1>
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
        <div class="card">
            <div class="card-header">
                <strong>Room Details</strong>
            </div>
            <div class="card-body">
                <p><strong>Room Name:</strong> {{ $residence->room?->name ?? 'N/A' }}</p>
                <p><strong>Floor:</strong> {{ $residence->room?->floor_number ?? 'N/A' }}</p>
                <p><strong>Room Type:</strong> {{ $residence->room?->type ?? 'N/A' }}</p>
                <p><strong>Building Name:</strong> {{ $residence->room?->building?->build_name ?? 'N/A' }}</p>
                <p><strong>Start Date:</strong> {{ $residence->start_date?->format('d-m-Y') ?? 'N/A' }}</p>
                <p><strong>End Date:</strong> {{ $residence->end_date?->format('d-m-Y') ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($residence->status) ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
@endsection
