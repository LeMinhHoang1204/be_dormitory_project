@extends('Auth_.index')
<head>
    <title>Activities List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
</head>

@section('content')
    @include('layouts.sidebar_student')
    @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'student', 'building manager']))
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
            <div class="bluefont" style="border: #4a5568 0.2px solid"><h3>Detail Activities</h3></div>
                <div class="student-list">
                <a href="{{ route('activity.participants', ['activity' => $activity->id]) }}">List of registered students</a>
                </div>
            <div class="popup-details">
                <div class="info-left">
                    <p><strong>Title:</strong>{{ $activity->title }}</p>
                    <p><strong>Create by:</strong>{{ $activity->creator->name }}</p>
                    <p><strong>Registered Participants:</strong> {{ $activity->registered_participants }}/{{ $activity->max_participants }}</p>
                    <p><strong>Registration Expiry Date:</strong> {{ \Carbon\Carbon::parse($activity->register_end_date)->format('d M, Y') }}</p>
                    <p><strong>Start Date:</strong>{{ \Carbon\Carbon::parse($activity->start_date)->format('d M, Y') }}</p>
                    @if (auth()->check() && auth()->user()->role === 'student')
                        <p><strong>Your status:</strong>
                            {{ $activity->hasParticipants->where('participant_id', auth()->id())->first()->status ?? 'Not Registered' }}
                        </p>
                    @endif
                </div>
                <div class="info-right">
                    <p><strong>Activity id:</strong>  #ACT_{{ $activity->id }}</p>
                    <p><strong>Create Date:</strong> {{ \Carbon\Carbon::parse($activity->created_at)->format('d M, Y') }}</p>
                    <p><strong>Ticket price (VND):</strong> {{ number_format($activity->ticket_price, 0, '.', ',') }}</p>
                    <p><strong>Bonus point:</strong> {{ $activity->bonus_point }}</p>
                    <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($activity->end_date)->format('d M, Y') }}</p>
                    <p><strong>Activity's status:</strong> {{ $activity->status }}</p>
                </div>
            </div>

            <!-- About Section -->
            <div class="popup-about">
                <h3>About this activity:</h3>
                <p>{{ $activity->description ?? 'There is no information!' }}</p>
                <h3>Note:</h3>
                <p>{{ $activity->note ?? 'There is no information!' }}</p>
            </div>

            @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'building manager']))
                <!-- Buttons -->
                <div class="popup-buttons">
                    <a href="javascript:void(0);" class="grey-btn" onclick="goBack()">< Back</a>

                    <script>
                        function goBack() {
                            window.location.href = "{{ route('admin.activities.index') }}";
                        }
                    </script>

                    <!-- Delete Button -->
                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" id="delete-form-{{ $activity->id }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="red-btn" onclick="return confirm('Are you sure you want to delete this activity?')">
                            Delete
                        </button>
                    </form>

                    <!-- Edit Button -->
                    <button class="blue-btn">Edit</button>
                </div>
            @endif

            @if (auth()->check() && auth()->user()->role === 'student')
                <div class="popup-buttons">

                    <a href="javascript:void(0);" class="grey-btn" onclick="goBack()">< Back</a>

                    <script>
                        function goBack() {
                            window.location.href = "{{ route('activities.index') }}";
                        }
                    </script>
                    <form action="{{ route('student_activities.register', ['activity' => $activity->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="blue-btn"> Register</button>
                    </form>

                </div>
            @endif
        </div>
    @endif

    @if (auth()->check() && in_array(auth()->user()->role, [ 'accountant']))
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
            <div>
                <p style="color: var(--Close, #FF2F5C);
                    font-family: Poppins;
                    font-size: 16px;
                    font-style: italic;
                    font-weight: 400;
                    line-height: normal;">
                    You can not access this page!
                </p>
            </div>
        </div>
    @endif


@endsection
<style>
    .bluefont {
        margin-bottom: 15px!important;
    }
    .extension{
        position: relative;
        max-width: 45%;
        padding-left: 40px;
        padding-right: 40px;
    }
    .student-list {
        /*position: absolute;*/
        /*top: 100px;*/
        /*right: 250px;*/
        color: #2F6BFF;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        font-style: italic;
        font-weight: 400;
        line-height: 14px; /* 107.692% */
        text-decoration-line: underline;
        text-decoration-style: solid;
        text-decoration-skip-ink: none;
        text-decoration-thickness: auto;
        text-underline-offset: auto;
        text-underline-position: from-font;
        margin-bottom: 25px!important;

    }
</style>
