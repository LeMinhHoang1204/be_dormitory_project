@extends('Auth_.index')

<head>
    <title>Check Out</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/checkout.css') }}" type="text/css">
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="checkout-container">
        <h3 class="heading">Check Out</h3>

        <div class="student-info">


            <div class="info-left">
                <p><strong>Full name:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Gender:</strong> {{ isset($student) ? $student->gender :'Cant find' }}</p> <!-- Gender -->
                <p><strong>Student ID:</strong> {{ isset($student) ? $student->id : 'Cant find' }}</p>
                <p><strong>University:</strong> {{ isset($student) ? $student->uni_name : 'University Name' }}</p>
                <p><strong>Date of birth:</strong> {{ isset($student) ? \Carbon\Carbon::parse($student->dob)->format('d-m-Y') : '01-01-2000' }}</p>
                <p><strong>Phone number:</strong> {{ isset($student) ? $student->user->phone_number : '0123456789' }}</p>
            </div>

            <div class="info-right">
                <p><strong>Email:</strong> {{ isset($student) ? $student->user->email : 'email@example.com' }}</p>
                <p><strong>Room:</strong> {{ isset($studentRoom) ? $studentRoom->name : 'Room 101' }}</p>
                <p><strong>Building:</strong> {{ isset($studentRoom) ? $studentRoom->building->build_name : 'Building A' }}</p>
                <p><strong>Check-in Date:</strong> {{ isset($studentRoom) ? \Carbon\Carbon::parse($studentRoom->pivot->start_date)->format('d-m-Y') : '01-12-2023' }}</p>
                <p><strong>Expiration Date:</strong> {{ isset($studentRoom) ? \Carbon\Carbon::parse($studentRoom->pivot->end_date)->format('d-m-Y') : '01-12-2024' }}</p>
                <p><strong>Unit Price:</strong> {{ isset($studentRoom) ? number_format($studentRoom->unit_price) : '800,000' }} VNĐ</p> <!-- Unit Price -->
            </div>
        </div>

        <form action="{{ route('student.leave') }}" method="POST">
            @csrf
            <div class="buttons">
                <!-- Button Cancel, chuyển hướng đến trang dashboard -->
                <a href="{{ route('dashboard') }}" class="btn-cancel">Cancel</a>

                <!-- Button Leave -->
                <button type="submit" class="btn-leave">Leave</button>
            </div>
        </form>


        @if(session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif
    </div>
@endsection
