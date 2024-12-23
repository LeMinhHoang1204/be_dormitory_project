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

        @foreach($residences as $residence)
            <div class="current-room-info">
                <h5 class="section-title">Room Details</h5>
                <p><strong>Building:</strong> {{ $residence->room->building->id }} - {{ $residence->room->building->build_name }}</p>
                <p><strong>The information that is only valid at that time </strong></p>
                <p><strong>Room:</strong> {{ $residence->room->id }} - {{ $residence->room->name }}</p>
                <p><strong>Room Price:</strong> {{ $residence->room->unit_price }}</p>
                <p><strong>Room Type:</strong> {{ $residence->room->type }}</p>
                <p><strong>Room Member:</strong> {{ $residence->room->member_count }}</p>
                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($residence->start_date)->format('d-m-Y H:i:s') }}</p>
                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($residence->end_date)->format('d-m-Y H:i:s') }}</p>
                <p><strong>Status:</strong> {{ $residence->status }}</p>
                <p><strong>Note:</strong> {{ $residence->note }}</p>
            </div>
        @endforeach

        <div class="section" style="align-content: space-between">
            <button class="grey-btn" onclick="window.location.href='{{ route('dashboard') }}'">< Back</button>
        </div>
{{--            @endif--}}
        @if(isset($message))
            <div class="message-alert">
                {{ $message }}
            </div>
        @endif
    </div>
@endsection

