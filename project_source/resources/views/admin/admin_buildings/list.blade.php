@extends('Auth_.index')

<head>
    <title>Building List</title>
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/table.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        .extension{
            max-width: 55%;
        }
    </style>
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">
        <h3 class="heading">Buildings List</h3>
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
        <a href="{{ route('buildings.create') }}" class="blue-btn">
            {{ __('Create') }}
        </a>

        <table class="table">
            <thead class="thead">
            <tr>
                <th>No.</th>
                <th>Id</th>
                <th>Building</th>
                <th>Manager</th>
                <th>Type</th>
                <th>Floor </th>
                <th>Room </th>
                <th>Student Count</th>
{{--                <th>Grant</th>--}}
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($buildings  as $index => $building)
                 <tr>
                     <td>{{ ($buildings->currentPage() - 1) * $buildings->perPage() + $loop->iteration }}</td>
                     <td>{{ $building->id }}</td>
                    <td>{{ $building->build_name }}</td>
                    <td>{{ $building->managedBy->user->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($building->type) }}</td>
                    <td>{{ $building->floor_numbers }}</td>
                    <td>{{ $building->room_numbers }}</td>
                    <td>{{ $building->student_count }}</td>
                    <td>
                        <div class="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical" onclick="toggleDropdown(event)"></i>
                            <div class="dropdown-content">
                                <a href="{{ route('buildings.show', $building->id) }}" class="more">
                                    More
                                </a>
                                <a href="{{ route('buildings.edit', $building->id) }}" class="register">
                                    <i class="fa-solid fa-pen-nib"></i> Edit
                                </a>
                                <a href="{{ route('buildings.destroy', $building->id) }}" class="delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $building->id }}').submit();">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>

                                <form id="delete-form-{{ $building->id }}" action="{{ route('buildings.destroy', $building->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>


                            </div>
                        </div>
                    </td>
                 </tr>

{{--                            <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this building?');">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button type="submit" class="red-btn">--}}
{{--                                    Delete--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
            @empty
                <tr>
                    <td colspan="8" class="text-center">No buildings found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination">
            @if ($buildings->onFirstPage())
                <span class="gap">Previous</span>
            @else
                <!-- Giữ tham số lọc khi chuyển trang -->
                <a href="{{ request()->fullUrlWithQuery(['page' => $buildings->currentPage() - 1]) }}" class="previous">Previous</a>
            @endif

            @foreach ($buildings->getUrlRange(1, $buildings->lastPage()) as $page => $url)
                @if ($page == $buildings->currentPage())
                    <span class="pagination-page current">{{ $page }}</span>
                @else
                    <!-- Giữ tham số lọc khi chuyển trang -->
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page]) }}" class="pagination-page">{{ $page }}</a>
                @endif
            @endforeach

            @if ($buildings->hasMorePages())
                <a href="{{ request()->fullUrlWithQuery(['page' => $buildings->currentPage() + 1]) }}" class="next">Next</a>
            @else
                <span class="gap">Next</span>
            @endif
        </div>

        <p>{{ $buildings->currentPage() }} / {{ $buildings->lastPage() }}</p>

    </div>
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
@endsection



