@extends('Auth_.index')

@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const error = @json(session('error'));
            // Display the notification
            toastr.warning(
                `${error.message}`
            );
        });
    </script>
@endif

<style>
    .toast-warning {
        color: #ffffff !important; /* Text color for warning notification */
        background-color: #ffc107 !important; /* Background color */
        font-family: "Poppins", sans-serif !important; /* Font family */
        border-left: 5px solid #ff9800 !important; /* Left border color */
    }

    .toast-info {
        color: #ffffff !important; /* Màu chữ cho thông báo thông tin */
        background-color: #17a2b8 !important; /* Màu nền */
        font-family: "Poppins", sans-serif !important; /* Font chữ */
    }
</style>

<head>
    <title>Check Out</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/checkout.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    {{-- WEBSITE: toastr --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
                <p><strong>Phone number:</strong> {{ isset($student) ? $student->user->phone : '0123456789' }}</p>
            </div>

            <div class="info-right">
                <p><strong>Email:</strong> {{ isset($student) ? $student->user->email : 'email@example.com' }}</p>
                <p><strong>Room:</strong> {{ isset($residence) ? $residence->room->name : 'Room 101' }}</p>
                <p><strong>Building:</strong> {{ isset($residence) ? $residence->room->building->build_name : 'Building A' }}</p>
                <p><strong>Check-in Date:</strong> {{ isset($residence) ? \Carbon\Carbon::parse($residence->start_date)->format('d-m-Y') : '01-12-2023' }}</p>
                <p><strong>Expiration Date:</strong> {{ isset($residence) ? \Carbon\Carbon::parse($residence->end_date)->format('d-m-Y') : '01-12-2024' }}</p>
                <p><strong>Status:</strong> {{ isset($residence) ? $residence->status : '' }} </p> <!-- Unit Price -->
            </div>
        </div>

        <form action="{{ route('students.leave', $residence->id) }}" method="POST">
            @csrf
            <div class="buttons">
                <!-- Button Cancel, chuyển hướng đến trang dashboard -->
                <a href="{{ route('dashboard') }}" class="grey-btn">Cancel</a>

                <input type="hidden" name="type" value="Check out">
                <!-- Button Leave -->
                <button type="submit" class="red-btn">Leave</button>
            </div>
        </form>


    </div>
@endsection
