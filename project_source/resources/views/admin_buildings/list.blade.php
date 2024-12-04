@extends('Auth_.index')

<head>
    <title>Building List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="buildinglist">
        <h3 class="heading">Buildings List</h3>

        <a href="{{ route('buildings.create') }}" class="btn-custom">
            {{ __('Create') }}
        </a>

        <table class="table">
            <thead class="thead">
            <tr>
                <th>Building</th>
                <th>Manager</th>
                <th>Type</th>
                <th>Floor Numbers</th>
                <th>Room Numbers</th>
                <th>Student Count</th>
                <th>Grant</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($buildings as $building)
                <tr onclick="window.location='{{ route('buildings.show', $building->id) }}'" style="cursor: pointer;">
                    <td>{{ $building->buil_name }}</td>
                    <td>{{ $building->managed->user->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($building->type) }}</td>
                    <td>{{ $building->floor_numbers }}</td>
                    <td>{{ $building->room_numbers }}</td>
                    <td>{{ $building->student_count }}</td>
                    <td>
                        <form action="{{ route('buildings.updateManager', $building->id) }}" method="POST" onclick="event.stopPropagation();">
                            @csrf
                            @method('PUT')
                            <select name="manager_id" class="form-control">
                                @if($building->manager_id)
                                    <option value="{{$building->managedBy->id}}" selected>{{$building->managedBy->user->name}}</option>
                                @else
                                    <option value="">-- Select Manager --</option>
                                @endif

                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ $building->manager_id == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->user->name }}
                                    </option>
                                @endforeach

                                @if($building->manager_id)
                                    <option value="">-- Delete current manager --</option>
                                @endif
                            </select>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </td>
                    <td>
                        <div class="btn">
                                <span class="btn-edit">
                                    <a href="{{ route('buildings.edit', $building->id) }}" >
                                        Edit
                                    </a>
                                </span>

                            <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this building?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No buildings found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

<style>
    body {
        background-color: #f9fafc;
        font-family: "Poppins", sans-serif;
    }

    .buildinglist {
        max-width: 70%;
        margin: 40px auto;
        padding: 30px;
        background-color: #f9f9f9;
        box-shadow: 0px 6px 4px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
    }

    .heading {
        font-family: Inter;
        color: #0e3b9c;
        font-size: 36px;
        font-weight: 700;
        text-align: center;
    }

    .btn-custom {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 110px;
        height: 45px;
        background-color: #2F6BFF;
        color: white;
        border-radius: 10px;
        border: none;
        text-align: center;
        font-size: 18px;
        /*text-decoration: none;*/
        /*cursor: pointer;*/
        transition: background-color 0.3s ease;
        font-family: Poppins;
    }

    .btn-custom:hover {
        background-color: #2568cc; /* Hiệu ứng hover */
        color: white;
        text-decoration: none; /* Đảm bảo không có gạch chân khi hover */
    }

    .table {
        width: 100%;
        margin-top: 20px;
        color: #ECEFFF;
        border-collapse: collapse;
        border-radius: 20px;
    }

    .table thead {
        background-color: #ECEFFF;
        border-radius: 20px 20px 0px 0px;
    }

    th, td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background-color: #fff;
        line-height: 1.4;
    }
</style>



{{--<x-app-layout>--}}

{{--    <head>--}}
{{--        <link rel="stylesheet" href="{{ asset('css/Notification/notification.css') }}" type="text/css">--}}
{{--    </head>--}}
{{--    @include('layouts.sidebar_student')--}}

{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-blue-700 leading-tight">--}}
{{--            {{ __('Buildings List') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="container">--}}
{{--        <h1 class="text-center my-4">Buildings List</h1>--}}
{{--        --}}{{--Create--}}
{{--        <x-primary-button>--}}
{{--            <a href="{{ route('buildings.create') }}" style="color: white; text-decoration: none;">--}}
{{--                {{ __('Create') }}--}}
{{--            </a>--}}
{{--        </x-primary-button>--}}

{{--        <table class="table table-bordered table-striped mt-4">--}}
{{--            <thead class="thead-dark">--}}
{{--            <tr>--}}
{{--                <th>ID</th>--}}
{{--                <th>Manager</th>--}}
{{--                <th>Type</th>--}}
{{--                <th>Floor Numbers</th>--}}
{{--                <th>Room Numbers</th>--}}
{{--                <th>Student Count</th>--}}
{{--                <th>Grant</th>--}}
{{--                <th>Action</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @forelse($buildings as $building)--}}
{{--                <tr onclick="window.location='{{ route('buildings.show', $building->id) }}'" style="cursor: pointer;">--}}
{{--                    <td>{{ $building->id }}</td>--}}
{{--                    <td>{{ $building->managed->user->name ?? 'N/A' }}</td>--}}
{{--                    <td>{{ ucfirst($building->type) }}</td>--}}
{{--                    <td>{{ $building->floor_numbers }}</td>--}}
{{--                    <td>{{ $building->room_numbers }}</td>--}}
{{--                    <td>{{ $building->student_count }}</td>--}}
{{--                    <td>--}}
{{--                        <form action="{{ route('buildings.updateManager', $building->id) }}" method="POST" onclick="event.stopPropagation();">--}}
{{--                            @csrf--}}
{{--                            @method('PUT')--}}
{{--                            <select name="manager_id" class="form-control">--}}
{{--                                @if($building->manager_id)--}}
{{--                                    <option value="{{$building->managed->id}}" selected>{{$building->managed->user->name}}</option>--}}
{{--                                @else--}}
{{--                                    <option value="">-- Select Manager --</option>--}}
{{--                                @endif--}}

{{--                                @foreach($managers as $manager)--}}
{{--                                    <option value="{{ $manager->id }}" {{ $building->manager_id == $manager->id ? 'selected' : '' }}>--}}
{{--                                        {{ $manager->user->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}

{{--                                @if($building->manager_id)--}}
{{--                                    <option value="">-- Delete current manager --</option>--}}
{{--                                @endif--}}
{{--                            </select>--}}
{{--                            <button type="submit" class="btn btn-primary">Save</button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <div class="btn" >--}}
{{--                            <!-- Edit Button -->--}}
{{--                            <span class="btn-edit">--}}
{{--                                    <a href="{{ route('buildings.edit', $building->id) }}" >--}}
{{--                                        Edit--}}
{{--                                    </a>--}}
{{--                            </span>--}}

{{--                            --}}{{--<span>--}}
{{--                            <!-- Delete Button -->--}}
{{--                            <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this building?');">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button type="submit" class="btn-delete">--}}
{{--                                    Delete--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                            --}}{{--                                </span>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @empty--}}
{{--                <tr>--}}
{{--                    <td colspan="6" class="text-center">No buildings found</td>--}}
{{--                </tr>--}}
{{--            @endforelse--}}
{{--            </tbody>--}}
{{--        </table>--}}
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
{{--</x-app-layout>--}}
