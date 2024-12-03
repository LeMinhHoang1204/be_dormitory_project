@extends('Auth_.index')

<head>
    <title>Room Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/roomInfor.css') }}" type="text/css">
    <script src="{{ asset('./roomInfor.js') }}"></script>
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="container">
        <main>
            <section class="room-info">
                <h1>Room Information</h1>
                <div class="room-details">
                    <div class="room-meta">
                        <h2></h2>
                        <span></span>
                        <p>Address: Ho Chi Minh City</p>
                        <p>Size: 30 sqm</p>
                        <p>Floor: 3rd</p>
                        <p>Available from: 1st November 2023</p>
                        <button class="change-button" onclick="toggleConfirm()">Register</button>
                    </div>
                    <div class="room-image">
                        <img src="" alt="Room Image">
                    </div>
                </div>
                <div class="room-description">
                    <h3>Overview</h3>
                    <p>The room is cozy and bright with soft cream-colored walls. A comfortable sofa sits in the center,
                        draped with blankets. A small desk holds a laptop and papers. A bookshelf filled with books and
                        plants adds personality. Soft lighting and a rug create a warm, inviting atmosphere.</p>
                </div>
                <div class="photos">
                    <h3>Photos</h3>
                    <div class="photo-grid">
                        <img src="{{ asset('images/room1.jpg') }}" alt="Room Image 1">
                        <img src="{{ asset('images/room1.jpg') }}" alt="Room Image 2">
                        <img src="{{ asset('images/room1.jpg') }}" alt="Room Image 3">
                    </div>
                </div>
                <div class="facilities">
                    <h3>Facilities</h3>
                    <ul>
                        <li>✔ Wifi</li>
                        <li>✔ Washing machine: 1</li>
                        <li>✔ Water heater: 1</li>
                        <li>✔ Air conditioning</li>
                        <li>✔ Refrigerator</li>
                        <li>✔ Microwave</li>
                        <li>✔ Parking space</li>
                    </ul>
                </div>
            </section>
        </main>
    </div>

    {{-- <div class="confirm-regis hidden">
        <h2>Are you sure to register this room?</h2>
        <div class="button-container">
            <button class="no-btn" onclick="closeConfirm()">No</button>
            <button class="yes-btn" onclick="showConfirmInfoContainer()">Yes</button>
        </div>
    </div>

    <script>
        function toggleConfirm() {
            document.querySelector('.confirm-regis').classList.toggle('hidden');
        }

        function closeConfirm() {
            document.querySelector('.confirm-regis').classList.add('hidden');
        }

        function showConfirmInfoContainer() {
            alert('Register room successfully!');
        }
    </script> --}}
@endsection
