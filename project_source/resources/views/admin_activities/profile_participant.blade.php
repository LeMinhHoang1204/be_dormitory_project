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
    @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'building manager']))
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

            <div class="bluefont" style="border: #4a5568 0.2px solid">
                <h3>Student Profile</h3>
            </div>
                <div class="profile-image">
                    <img src="{{ auth()->user()->profile_image_path && file_exists(storage_path('app/public/' . auth()->user()->profile_image_path))
                                ? asset('storage/' . auth()->user()->profile_image_path)
                                : asset('images/avatar.png')  }}"
                     alt="User Avatar"
                     class="profile-img">
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
                        <p><strong>Residence:</strong> {{ $currentResidence->status ?? 'No residence' }}</p>
                    </div>
                </div>



            <!-- About Section -->
            <div class="popup-about">
                <h3>Bio:</h3>
                <p>{{ auth()->user()->bio ?? 'There is no bio provided!' }}</p>
            </div>
                <div class="popup-buttons">
                    <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>
                    <script>
                        function goBack() {
                            const activityId = {{ $activity->id ?? 'null' }};
                            if (activityId) {
                                window.location.href = "{{ route('activity.participants', ['activity' => ':id']) }}".replace(':id', activityId);
                            } else {
                                alert('Activity ID is missing!');
                            }
                        }
                    </script>
                </div>
        </div>
    @endif

    @if (auth()->check() && auth()->user()->role === 'accountant')
        <div class="extension">
            <div>
                <p style="color: var(--Close, #FF2F5C);
                    font-family: Poppins;
                    font-size: 16px;
                    font-style: italic;
                    font-weight: 400;
                    line-height: normal;">
                    You cannot access this page!
                </p>
            </div>
        </div>
    @endif
@endsection

<style>
    .bluefont {
        margin-bottom: 15px!important;
    }
    .extension {
        position: relative;
        max-width: 45%;
        padding-left: 40px;
        padding-right: 40px;
    }
    .student-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .info-left,
    .info-right {
        width: 48%;
    }
    .popup-about {
        margin-top: 20px;
        font-size: 14px;
    }
    .popup-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }
    .grey-btn,
    .blue-btn {
        padding: 10px 20px;
        text-decoration: none;
        color: white;
        border-radius: 5px;
    }
    .grey-btn {
        background-color: grey;
    }
    .blue-btn {
        background-color: #2F6BFF;
    }
</style>
