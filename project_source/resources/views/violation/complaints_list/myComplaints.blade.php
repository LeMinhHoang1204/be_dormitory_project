@extends('Auth_.index')
<head>
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/avatar.css') }}" type="text/css">
</head>
@section('content')
    @include('layouts.sidebar_student')
    <div class="extension">

    <h3 class="heading">My Complaints</h3>
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
        @if($complaints->isEmpty())
            <p>No complaints found.</p>
        @else
            <table class="table">
                <thead class="thead">
                <tr>
                    <th>ID</th>
                    <th>Violation</th>
                    <th>Student</th>
                    <th>Creator</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>#{{ $complaint->violation->id }} - {{ $complaint->violation->title }}</td>
                        <td>{{ $complaint->student->name }}</td>
                        <td>{{ $complaint->creator->name }}</td>
                        <td>{{ $complaint->created_at }}</td>
                        <td>{{ $complaint->status }}</td>
                        <td>
                            <div class="dropdown">

                                <i class="fa-solid fa-ellipsis-vertical" onclick="toggleDropdown(event)"></i>
                                <!-- Menu dropdown -->
                                <div class="dropdown-content">
                                    {{--                                <a href="#" class="more"  data-id="{{ $activity->id }}" onclick="toggleDetail(this)">--}}
                                    {{--                                    More--}}
                                    {{--                                </a>--}}
                                    <a href="{{ route('complaints.show', ['id' => $complaint->id]) }}" class="more">
                                        More
                                    </a>
                                    @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'building manager'))
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('accept-form-{{ $complaint->id }}').submit();" class="register">
                                            <i class="fa-solid fa-pen-nib"></i> Accept
                                        </a>

                                        <a href="#" onclick="event.preventDefault(); document.getElementById('decline-form-{{ $complaint->id }}').submit();" class="delete">
                                            <i class="fa-solid fa-trash"></i> Decline
                                        </a>

                                        <!-- Form để gửi POST request -->
                                        <form id="accept-form-{{ $complaint->id }}" action="{{ route('complaint.accept', $complaint->id) }}" method="POST" style="display:none;">
                                            @csrf
                                        </form>

                                        <form id="decline-form-{{ $complaint->id }}" action="{{ route('complaint.decline', $complaint->id) }}" method="POST" style="display:none;">
                                            @csrf
                                        </form>
                                    @endif


                                @if(auth()->check() && auth()->user()->role === 'student')

                                    <form action="{{ route('complaint.destroy', $complaint->id) }}" method="POST" id="delete-form-{{ $complaint->id }}" onsubmit="return confirm('Are you sure you want to delete this violation?')">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" class="delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $complaint->id }}').submit();">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </a>
                                    </form>
                                    @endif

                                </div>
                            </div>
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
            <script>
                // Toggle dropdown menu khi nhấn vào icon ba chấm cột Action
                function toggleDropdown(event) {
                    var dropdown = event.target.closest('.dropdown');
                    var dropdownContent = dropdown.querySelector('.dropdown-content');

                    // Đóng tất cả các dropdown khác
                    var allDropdowns = document.querySelectorAll('.dropdown-content');
                    allDropdowns.forEach(function(content) {
                        if (content !== dropdownContent) {
                            content.style.display = 'none';
                        }
                    });

                    // Toggle trạng thái hiển thị của dropdown hiện tại
                    if (dropdownContent.style.display === "block") {
                        dropdownContent.style.display = "none";
                    } else {
                        dropdownContent.style.display = "block";
                    }
                }

                // Đóng dropdown khi nhấn ngoài menu
                window.onclick = function(event) {
                    if (!event.target.matches('.fa-ellipsis-vertical')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        for (var i = 0; i < dropdowns.length; i++) {
                            var openDropdown = dropdowns[i];
                            if (openDropdown.style.display === "block") {
                                openDropdown.style.display = "none";
                            }
                        }
                    }
                }

            </script>
        @endif

    </div>
@endsection
