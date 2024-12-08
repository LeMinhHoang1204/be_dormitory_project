{{-- resources/views/activities/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="activity-details">
        <h3>{{ $activity->title }}</h3>
        <p>{{ $activity->description }}</p>
        <p>Start Date: {{ $activity->start_date }}</p>
        <p>End Date: {{ $activity->end_date }}</p>
        <p>Registered: {{ $activity->registered_participants }}/{{ $activity->max_participants }}</p>

        @if(Auth::check())
            @php
                $user = Auth::user();
                $registration = $activity->registrations()->where('participant_id', $user->id)->first();
            @endphp

            @if($registration && $registration->status == 'Registered')
                <form action="{{ route('activities.cancel', $activity->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cancel Registration</button>
                </form>
            @elseif(!$registration)
                <form action="{{ route('activities.register', $activity->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            @endif
        @endif
    </div>
@endsection
