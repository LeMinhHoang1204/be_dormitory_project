@extends('Auth_.index')
<head>
    <title>Update Building</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
</head>
@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">
        <div class="bluefont"><h3>Update Building</h3></div>
        <p><strong>Building ID:</strong> #_{{ $building->id }}</p>
        <p><strong>Create Date:</strong> {{ \Carbon\Carbon::parse($building->created_at)->format('d M, Y') }}</p>

        <form action="{{ route('buildings.update', $building->id) }}" method="POST">
            @csrf
{{--            @method('PUT')--}}
            <div class="form-container">
                <div class="form-group">
                    <label for="floor_numbers">Floor numbers:</label>
                    <input
                        type="number"
                        id="floor_numbers"
                        name="floor_numbers"
                        value="{{ old('floor_numbers', $building->floor_numbers) }}"
                        min="1"
                        required>
                    @error('floor_numbers')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="room_numbers">Room numbers:</label>
                    <input
                        type="number"
                        id="room_numbers"
                        name="room_numbers"
                        value="{{ old('room_numbers', $building->room_numbers) }}"
                        min="1"
                        required>
                    @error('room_numbers')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="manager_id" class="block text-gray-700 font-bold mb-2">Manager:</label>
                    <select id="manager_id" name="manager_id" class="option">
                        <option value="">-- Select Manager --</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ $building->manager_id == $manager->id ? 'selected' : '' }}>
                                {{ $manager->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Type:</label>
                    <select name="type" id="type" required>
                        <option value="male" {{ $building->type == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $building->type == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('type')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>

                <a href="{{ route('rooms.create', ['building' => $building->id]) }}" class="blue-btn">
                         {{ __('Add room') }}
                </a>
                <button type="submit" class="blue-btn" >Update</button>
                <script>
                    function goBack() {
                        window.location.href = "{{ route('buildings.index') }}";
                    }
                </script>
            </div>
        </form>

    </div>

    <style>
        .form-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form-group {
            margin-bottom: 15px;
            flex: 0 0 30%;
            flex-direction: row;
            align-items: center;
        }

        .form-group label {
            display: inline-block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #0E3B9C;
            font-family: Poppins;
        }

        .form-group select,
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: border 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #4a90e2;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .form-actions .grey-btn,
        .form-actions .blue-btn {
            margin-left: 10px;
        }
    </style>
@endsection
