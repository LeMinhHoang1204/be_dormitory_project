@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

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

        <h3>Student Profile</h3>

        <div class="profile-image">
            <img src="{{ $student->user->profile_image_path && file_exists(storage_path('app/public/' . $student->user->profile_image_path))
                        ? asset('storage/' . $student->user->profile_image_path)
                        : asset('images/avatar.png') }}"
                 alt="User Avatar" class="profile-img">
        </div>

        <div class="student-details">
            <div class="info-left">
                <p><strong>Name:</strong> {{ $student->user->name }}</p>
                <p><strong>Email:</strong> {{ $student->user->email }}</p>
                <p><strong>Phone:</strong> {{ $student->user->phone ?? 'Not provided' }}</p>
                <p><strong>University ID:</strong> {{ $student->uni_id }}</p>
                <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->dob)->format('d M, Y') }}</p>
            </div>
            <div class="info-right">
                <p><strong>Student ID:</strong> #STU_{{ $student->id }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                <p><strong>Room:</strong> {{ $currentResidence->room->name ?? 'No room assigned' }}</p>
                <p><strong>Residence Status:</strong> {{ $currentResidence->status ?? 'No residence' }}</p>
            </div>
        </div>

        <div class="popup-about">
            <h3>Bio:</h3>
            <p>{{ auth()->user()->bio ?? 'There is no bio provided!' }}</p>
        </div>

        <div class="popup-buttons">
            <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </div>
    </div>
@endsection
