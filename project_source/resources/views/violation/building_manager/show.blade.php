@extends('Auth_.index')

<head>
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/user_profile.php.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/avatar.css') }}" type="text/css">

</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="extension">
        <div class="bluefont" style="border: #4a5568 0.2px solid">
            <h3>Violation Detail</h3>
        </div>
            <div class="profile-image">
{{--                @if($student && $student->user)--}}
                <img src="{{ $receiver->profile_image_path && file_exists(storage_path('app/public/' . $receiver->profile_image_path))
                    ? asset('storage/' . $receiver->profile_image_path)
                    : asset('images/avatar.png') }}"
                     alt="User Avatar"
                     class="profile-img">
{{--                @else--}}
{{--                    <img src="{{ asset('images/avatar.png') }}" alt="Default Avatar" class="profile-img">--}}
{{--                @endif--}}
            </div>
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
            <div class="modal-body">
                <div class="violation-details">
                    <div class="violation-info">
                        <p><strong>Violation ID:</strong> #{{ $violation->id }}</p>
                        <p><strong>Title:</strong> {{ $violation->title }}</p>
                        <p><strong>Name:</strong> {{ $student ? $student->user->name : 'No student assigned' }}</p>
                        <p><strong>Email:</strong> {{ $student ? $student->user->email : 'No email' }}</p>
                        <p><strong>Phone:</strong> {{ $student ? $student->user->phone ?? 'Not provided' : 'No phone' }}</p>
                        <p><strong>Room:</strong> {{ $currentResidence->room->name ?? 'No room assigned' }}</p>
                        <p><strong>Residence:</strong> {{ $currentResidence->status ?? 'No residence' }}</p>
                        <p><strong>Type of violation:</strong> {{ $violation->type }}</p>
                        <p><strong>Minus points:</strong> {{ $violation->minus_point }}</p>
                        <p><strong>Training point:</strong> {{ $student->training_point ?? 'Not found' }}</p>
                        <p><strong>Detail:</strong> {{ $violation->description }}</p>
                        <p><strong>Date Occurred:</strong> {{ \Carbon\Carbon::parse($violation->occurred_at)->format('d M, Y') }}</p>
                        {{--                        <p><strong>Images:</strong></p>--}}
                    </div>
                    <div class="manager-info" style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;">
                        <h4>Creator Violation</h4>
                        <p><strong>Name:</strong> {{ $manager->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $manager->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $manager->phone ?? 'Not provided' }}</p>
                        <p><strong>Created Violation At:</strong>
                            {{ \Carbon\Carbon::parse($violation->created_at)->format('d M, Y - H:i') }}
                        </p>
                    </div>
                </div>
                <div class="action-buttons">
{{--                    <a href="{{ route('violations.index') }}" class="btn btn-danger">Decline</a>--}}
{{--                    <a href="{{ route('violations.accept', $violation->id) }}" class="btn btn-success">Accept</a>--}}
                    <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>

                    <script>
                        function goBack() {
                            window.history.back();
                        }
                    </script>

                </div>
            </div>
        </div>
@endsection

