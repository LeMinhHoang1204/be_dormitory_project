{{--<x-app-layout>--}}

{{--    <head>--}}
{{--        <link rel="stylesheet" href="{{ asset('css/Notification/notification.css') }}" type="text/css">--}}
{{--    </head>--}}

{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-blue-700 leading-tight">--}}
{{--            {{ __('Residence Details') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="container">--}}
{{--        @can('create', App\Models\Residence::class)--}}
{{--            <x-primary-button>--}}
{{--                <a href="{{ route('residences.create' ,[$building->id, $room->id]) }}" style="color: white; text-decoration: none;">--}}
{{--                    {{ __('Add Residence') }}--}}
{{--                </a>--}}
{{--            </x-primary-button>--}}
{{--        @endcan--}}
{{--        <h2 class="text-center my-4">Residences</h2>--}}
{{--        <table class="table table-bordered table-striped mt-4">--}}
{{--            <thead class="thead-dark">--}}
{{--            <tr>--}}
{{--                <th>ID</th>--}}
{{--                <th>Student</th>--}}
{{--                <th>Room</th>--}}
{{--                <th>Start Date</th>--}}
{{--                <th>End Date</th>--}}
{{--                <th>Status</th>--}}
{{--                <th>Last Update</th>--}}
{{--                <th>Actions</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @forelse($residences as $residence)--}}
{{--                <tr>--}}
{{--                    <td>{{ $residence->id }}</td>--}}
{{--                    <td>{{ $residence->student->user->name ?? 'N/A' }}</td>--}}
{{--                    <td>{{ $residence->room_id ?? 'N/A' }}</td>--}}
{{--                    <td>{{ $residence->start_date }}</td>--}}
{{--                    <td>{{ $residence->end_date }}</td>--}}
{{--                    <td>{{ $residence->status }}</td>--}}
{{--                    <td>{{ $residence->updated_at->diffForHumans() }}</td>--}}
{{--                    <td>--}}
{{--                        <div class="btn">--}}
{{--                            <!-- Edit Button -->--}}
{{--                            <span class="btn-edit">--}}
{{--                                <a href="{{ route('residences.edit', [$building->id, $room->id, $residence->id]) }}">--}}
{{--                                    Edit--}}
{{--                                </a>--}}
{{--                            </span>--}}

{{--                            <!-- Delete Button -->--}}
{{--                            @can('delete', $residence)--}}
{{--                                <form action="{{ route('residences.destroy', [$building->id, $room->id, $residence->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this residence?');">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit" class="btn-delete">--}}
{{--                                        Delete--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            @endcan--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @empty--}}
{{--                <tr>--}}
{{--                    <td colspan="8" class="text-center">No residences found</td>--}}
{{--                </tr>--}}
{{--            @endforelse--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--        {{ $residences->links() }}--}}
{{--    </div>--}}

{{--    <style>--}}
{{--        .container {--}}
{{--            max-width: 1200px;--}}
{{--            margin: 0 auto;--}}
{{--            padding: 20px;--}}
{{--        }--}}

{{--        .text-center {--}}
{{--            text-align: center;--}}
{{--        }--}}

{{--        .my-4 {--}}
{{--            margin-top: 1.5rem;--}}
{{--            margin-bottom: 1.5rem;--}}
{{--        }--}}

{{--        .table {--}}
{{--            width: 100%;--}}
{{--            margin-bottom: 1rem;--}}
{{--            color: #212529;--}}
{{--            border-collapse: collapse;--}}
{{--        }--}}

{{--        .table-bordered {--}}
{{--            border: 1px solid #dee2e6;--}}
{{--        }--}}

{{--        .table-striped tbody tr:nth-of-type(odd) {--}}
{{--            background-color: rgba(0, 0, 0, 0.05);--}}
{{--        }--}}

{{--        .thead-dark th {--}}
{{--            color: #fff;--}}
{{--            background-color: #343a40;--}}
{{--            border-color: #454d55;--}}
{{--        }--}}

{{--        th, td {--}}
{{--            padding: 0.75rem;--}}
{{--            vertical-align: top;--}}
{{--            border-top: 1px solid #dee2e6;--}}
{{--        }--}}

{{--        th {--}}
{{--            text-align: inherit;--}}
{{--        }--}}

{{--        tr:hover {--}}
{{--            background-color: #f1f1f1;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <script>--}}
{{--        window.addEventListener('beforeunload', function () {--}}
{{--            localStorage.setItem('scrollPosition', window.scrollY);--}}
{{--        });--}}
{{--    </script>--}}

{{--    <script>--}}
{{--        window.addEventListener('load', function () {--}}
{{--            const scrollPosition = localStorage.getItem('scrollPosition');--}}
{{--            if (scrollPosition) {--}}
{{--                window.scrollTo(0, parseInt(scrollPosition, 10));--}}
{{--                localStorage.removeItem('scrollPosition');--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--</x-app-layout>--}}

@extends('Auth_.index')

<head>
    <title>Request List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Notification/notification.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/table.css') }}" type="text/css">
    <style>
        .extension{
            max-width: 67%;
        }
    </style>
</head>

@section('content')
    @include('layouts.sidebar_student')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Residence Details') }}
        </h2>
    </x-slot>

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

        <div class="bluefont">
            <h3>Residence Details</h3>
        </div>

        <div class="student-details">
            <div class="info-left">
                <p><strong>Building ID:</strong> #{{ $building->id }}</p>
                <p><strong>Building Name:</strong> {{ $building->build_name }}</p>
                <p><strong>Manager:</strong> {{ $building->managedBy->user->name ?? 'N/A' }}</p>
                <p><strong>Type:</strong> {{ ucfirst($building->type) }}</p>
            </div>
            <div class="info-right">
                <p><strong>Room ID:</strong> #{{ $room->id }}</p>
                <p><strong>Room name:</strong> {{ $room->name}}</p>
                <p><strong>Student Count:</strong> {{ $building->student_count }}</p>
            </div>
        </div>

        @can('create', App\Models\Residence::class)
                <a href="{{ route('residences.create', [$building->id, $room->id]) }}" style="color: white; text-decoration: none;" class="blue-btn">
                    {{ __('Add Student') }}
                </a>
        @endcan

        <table class="table">
            <thead class="thead">
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Room</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Last Update</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($residences as $residence)
                <tr>
                    <td>{{ $residence->id }}</td>
                    <td>{{ $residence->student->user->name ?? 'N/A' }}</td>
                    <td>{{ $residence->room_id ?? 'N/A' }}</td>
                    <td>{{ $residence->start_date }}</td>
                    <td>{{ $residence->end_date }}</td>
                    <td>{{ $residence->status }}</td>
                    <td>{{ $residence->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical" onclick="toggleDropdown(event)"></i>
                            <div class="dropdown-content">
                                <!-- Edit Button -->
                                <a href="{{ route('residences.edit', [$building->id, $room->id, $residence->id]) }}">
                                    <i class="fa-solid fa-pen-nib" style="margin-right:5px "></i> Edit
                                </a>
                                <!-- Delete Button -->
                                @can('delete', $residence)
                                    <form action="{{ route('residences.destroy', [$building->id, $room->id, $residence->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this residence?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="fa-solid fa-trash" style="margin-right:5px "></i> Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No residences found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <script>
        function toggleDropdown(event) {
            var dropdown = event.target.closest('.dropdown');
            var dropdownContent = dropdown.querySelector('.dropdown-content');

            // Close all other dropdowns
            var allDropdowns = document.querySelectorAll('.dropdown-content');
            allDropdowns.forEach(function(content) {
                if (content !== dropdownContent) {
                    content.style.display = 'none';
                }
            });

            // Toggle the current dropdown
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        }

        // Close dropdown when clicking outside the menu
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
    <style>
        .extension {
            position: relative;
            max-width: 55%;
            padding-left: 40px;
            padding-right: 40px;
        }

        .student-details p {
            margin: 10px 0;
        }

        .student-details p strong {
            margin-right: 12px;
        }

        .student-details {
            background-color: #c7d6fb;
            border-radius: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .info-left {
            margin-left: 25px;
        }

        .info-right {
            margin-right: 30px;
        }
    </style>
