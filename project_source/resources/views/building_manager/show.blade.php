@extends('Auth_.index')
<head>
    <title>Building Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/table.css') }}" type="text/css">
</head>
@section('content')
    @include('layouts.sidebar_student')

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
        <div class="bluefont"><h3>Building Details</h3></div>
        <div class="student-details">
            <div class="info-left">
                <p><strong>Building ID:</strong> #{{ $building->id }}</p>
                <p><strong>Building name:</strong> {{ $building->build_name }}</p>
                <p><strong>Manager:</strong> {{ $building->managedBy->user->name ?? 'N/A' }}</p>
                <p><strong>Type:</strong> {{ ucfirst($building->type) }}</p>
            </div>
            <div class="info-right">
                <p><strong>Create Date:</strong> {{ \Carbon\Carbon::parse($building->created_at)->format('d M, Y') }}</p>

                <p><strong>Floor Numbers:</strong>{{ $building->floor_numbers }}</p>
                <p><strong>Room Numbers:</strong> {{ $building->room_numbers }}</p>
                <p><strong>Student Count:</strong>{{ $building->student_count }}</p>
            </div>
        </div>
        <h3 style="color: #0e3b9c; text-align: center; font-family: 'Poppins', sans-serif; margin-bottom: -20px">Rooms</h3>
        <table class="table">
            <thead class="thead">
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Unit Price</th>
                <th>Member Count</th>
                <th>Status</th>
                <th>Last Update</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ ($rooms->currentPage() - 1) * $rooms->perPage() + $loop->iteration }}</td>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ ucfirst($room->type) }}</td>
                    <td>{{ $room->unit_price }}</td>
                    <td>{{ $room->member_count }}</td>
                    <td>{{ ucfirst($room->status) }}</td>
                    <td>{{ $room->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical" onclick="toggleDropdown(event)"></i>
                            <div class="dropdown-content">
                                @if (auth()->check() && auth()->user()->role === 'admin')
                                    <a href="{{ route('rooms.edit', ['building' => $building->id, 'room' => $room->id]) }}">
                                        <i class="fa-solid fa-pen-nib" style="margin-right:5px "></i> Edit
                                    </a>
                                @endif
                                <a href="{{ route('residences.index', ['building' => $building->id, 'room' => $room->id]) }}">
                                    <i class="fa-solid fa-person-booth" style="margin-right:5px "></i> Residences
                                </a>
                                    @if (auth()->check() && auth()->user()->role === 'admin')

                                    <a href="{{ route('rooms.destroy', ['building' => $building->id, 'room' => $room->id]) }}" class="delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $room->id }}').submit();">
                                    <i class="fa-solid fa-trash" style="margin-right:5px "></i> Delete
                                </a>

                                    <form id="delete-form-{{ $room->id }}" action="{{ route('rooms.destroy', ['building' => $building->id, 'room' => $room->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No rooms found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination">
            @if ($rooms->onFirstPage())
                <span class="gap">Previous</span>
            @else
                <a href="{{ $rooms->previousPageUrl() }}" class="previous">Previous</a>
            @endif

            @php
                $currentPage = $rooms->currentPage();
                $lastPage = $rooms->lastPage();
            @endphp

            @if ($lastPage <= 5)
                @for ($i = 1; $i <= $lastPage; $i++)
                    @if ($i == $currentPage)
                        <span class="pagination-page current">{{ $i }}</span>
                    @else
                        <a href="{{ $rooms->url($i) }}" class="pagination-page">{{ $i }}</a>
                    @endif
                @endfor
            @else
                @if ($currentPage > 3)
                    <a href="{{ $rooms->url(1) }}" class="pagination-page">1</a>
                    <span class="ellipsis">...</span>
                @endif

                @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
                    @if ($i == $currentPage)
                        <span class="pagination-page current">{{ $i }}</span>
                    @else
                        <a href="{{ $rooms->url($i) }}" class="pagination-page">{{ $i }}</a>
                    @endif
                @endfor

                @if ($currentPage < $lastPage - 2)
                    <span class="ellipsis">...</span>
                    <a href="{{ $rooms->url($lastPage) }}" class="pagination-page">{{ $lastPage }}</a>
                @endif
            @endif

            @if ($rooms->hasMorePages())
                <a href="{{ $rooms->nextPageUrl() }}" class="next">Next</a>
            @else
                <span class="gap">Next</span>
            @endif
        </div>

        <p style="text-align: center; margin-top: -10px">{{ $rooms->currentPage() }} / {{ $rooms->lastPage() }}</p>

        <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>
    </div>

    <script>
        function goBack() {
            window.location.href = "{{ route('buildings.index', $building->id) }}";
        }
    </script>
    <script>
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
<style>
    .extension {
        position: relative;
        max-width: 55%;
        padding-left: 40px;
        padding-right: 40px;
    }
    .text-center {
        text-align: center;
    }

    .student-details p{
        margin: 10px 0;
    }
    .student-details p strong{
        margin-right: 12px;
    }
    .student-details {
        background-color:#c7d6fb ;
        border-radius: 10px;
        width: 100%;
        align-items: center;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        margin-top: 10px;
        padding: 10px;
    }
    .info-left
    {
        margin-left: 25px;
    }
    .info-right{
        margin-right: 30px;
    }
</style>
