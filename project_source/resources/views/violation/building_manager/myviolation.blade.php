@extends('Auth_.index')

<head>
    <title>My Violations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/avatar.css') }}" type="text/css">
    <style>
        .all-violation-link {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            color: #2F6BFF;
            font-weight: 550;
            /*text-transform: uppercase;*/
            font-family: 'Poppins', sans-serif; /* Font */
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            background-color: #ffffff;
            margin: 10px 0;
        }

        .all-violation-link:hover {
            background-color: #2F6BFF;
            color: #ffffff;
            border-color: #2F6BFF;
            text-decoration: none;
            transform: translateY(-2px);
        }

    </style>
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">
        <h3 class="heading">  Violations </h3>
        @if(auth()->check() && auth()->user()->role === 'building manager'|| auth()->user()->role === 'admin')
        <div class="create-violation-button">
            <a href="{{ route('admin.violations.create') }}" class="blue-btn" >Create</a>
        </div>
            <a href="{{ route('violations.indexManager') }}" class="all-violation-link" style="float: right; margin-top: -15px">All Violation</a>
        @endif
        @if (session('success'))
            <div class="alert alert-success" style="margin-top: 20px">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" style="margin-top: 20px">
                {{ session('error') }}
            </div>
        @endif

        <table class="table">
            <thead class="thead">
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Creator</th>
                <th>Student Name</th>
                <th>Room</th>
                <th>Type</th>
                <th>Date</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($violations as $index => $violation)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $violation->id }}</td>
                    <td>{{ optional($violation->creator)->name ?? 'N/A' }}</td>
                    <td>{{ optional(optional(optional($violation->receiver)->student)->user)->name ?? 'N/A' }}</td>
                    <td>
                        @if ($violation->receiver && $violation->receiver->student && $violation->receiver->student->latestResidence)
                            {{ optional($violation->receiver->student->latestResidence->room)->name ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $violation->type }}</td>
                    <td>{{ \Carbon\Carbon::parse($violation->occurred_at)->format('Y-m-d H:i') }}</td>
                    <td>
                    <div class="dropdown">
                        <i class="fa-solid fa-ellipsis-vertical" onclick="toggleDropdown(event)"></i>
                        <!-- Menu dropdown -->
                        <div class="dropdown-content">
                            {{--                                <a href="#" class="more"  data-id="{{ $activity->id }}" onclick="toggleDetail(this)">--}}
                            {{--                                    More--}}
                            {{--                                </a>--}}
                            <a href="{{ route('violations.show', ['id' => $violation->id]) }}" class="more">
                                More
                            </a>

                            @if(auth()->check() && auth()->user()->role === 'student')
                                <a href="{{ route('violations.complaint', $violation->id) }}" class="register">
                                    <i class="fa-solid fa-pen-nib"></i> Complaint
                                </a>
                            @endif

                            @if(auth()->check() && auth()->user()->role === 'admin'|| auth()->user()->role === 'building manager')
                            <a href="{{ route('violations.edit', $violation->id) }}" class="register">
                                <i class="fa-solid fa-pen-nib"></i> Edit
                            </a>
                            {{--                                                        <a href="#" class="delete">--}}
                            {{--                                                            <i class="fa-solid fa-trash"></i> Delete--}}
                            {{--                                                        </a>--}}
                            <form action="{{ route('violation.destroy', $violation->id) }}" method="POST" id="delete-form-{{ $violation->id }}" onsubmit="return confirm('Are you sure you want to delete this violation?')">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $violation->id }}').submit();">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </form>
                            @endif

                        </div>
                    </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No violations found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination">
            @if ($violations->onFirstPage())
                <span class="gap">Previous</span>
            @else
                <a href="{{ $violations->previousPageUrl() }}" class="previous">Previous</a>
            @endif

            @php
                $currentPage = $violations->currentPage();
                $lastPage = $violations->lastPage();
            @endphp

            @if ($lastPage <= 5)
                @for ($i = 1; $i <= $lastPage; $i++)
                    @if ($i == $currentPage)
                        <span class="pagination-page current">{{ $i }}</span>
                    @else
                        <a href="{{ $violations->appends(request()->all())->url($i) }}" class="pagination-page">{{ $i }}</a>
                    @endif
                @endfor
            @else
                @if ($currentPage > 3)
                    <a href="{{ $violations->appends(request()->all())->url(1) }}" class="pagination-page">1</a>
                    <span class="ellipsis">...</span>
                @endif

                @for ($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                    @if ($i == $currentPage)
                        <span class="pagination-page current">{{ $i }}</span>
                    @else
                        <a href="{{ $violations->appends(request()->all())->url($i) }}" class="pagination-page">{{ $i }}</a>
                    @endif
                @endfor

                @if ($currentPage < $lastPage - 3)
                    <span class="ellipsis">...</span>
                    <a href="{{ $violations->appends(request()->all())->url($lastPage) }}" class="pagination-page">{{ $lastPage }}</a>
                @endif
            @endif

            @if ($violations->hasMorePages())
                <a href="{{ $violations->nextPageUrl() }}" class="next">Next</a>
            @else
                <span class="gap">Next</span>
            @endif
        </div>
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
    </div>
@endsection
