@extends('Auth_.index')

<head>
    <title>Create Room</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">
        @error('field_name')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="bluefont">
            <h3>Create New Room</h3>
        </div>
        <div class="student-details">
            <div class="info-left">
                <p><strong>Building ID:</strong> #{{ $building->id }}</p>
                <p><strong>Building name:</strong> {{ $building->build_name }}</p>
                <p><strong>Building Create Date:</strong> {{ \Carbon\Carbon::parse($building->created_at)->format('d M, Y') }}</p>
            </div>
            <div class="info-right">
                <p><strong>Manager:</strong> {{ $building->managedBy->user->name ?? 'N/A' }}</p>
                <p><strong>Room ID:</strong> #{{ $room->id }}</p>
                <p><strong>Room Create Date:</strong> {{ \Carbon\Carbon::now()->format('d M, Y') }}</p>
{{--                <p><strong></strong></p>--}}
            </div>
        </div>
        <form action="{{ route('rooms.store', $building->id) }}" method="POST">
                    @csrf
            @if ($errors->any())
                <div class="error-container">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="hidden" name="building_id" value="{{ $building->id }}">
            <div class="form-container">
                <!-- Room Name -->
{{--                <div class="form-group">--}}
{{--                    <label for="name">Room Name:</label>--}}
{{--                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter room name" required>--}}
{{--                    @error('name')--}}
{{--                    <div class="error">{{ $message }}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}
                <div class="form-group">
                    <label for="name">Room Name:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Room name will be generated" required readonly>
                    @error('name')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Floor Number -->
                <div class="form-group">
                    <label for="floor_number">Floor Number:</label>
                    <input type="number" id="floor_number" name="floor_number" value="{{ old('floor_number') }}" min="1" required>
                    @error('floor_number')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Room Type -->
                <div class="form-group">
                    <label for="type">Room Type:</label>
                    <select id="type" name="type" required>
                        <option value="">-- Select Type --</option>
                        @foreach ($distinctRoomTypes as $roomType)
                            <option value="{{ $roomType->type }}" {{ old('type') == $roomType->type ? 'selected' : '' }}>
                                {{ $roomType->type }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Unit Price -->
                <div class="form-group">
                    <label for="unit_price">Unit Price:</label>
                    <input type="number" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" placeholder="Enter unit price" min="0" required>
                    @error('unit_price')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>
                    <button type="submit" class="blue-btn">Create Room</button>
            </div>
        </form>
    </div>
    <script>
        // JavaScript to auto-generate room name based on floor number
        document.getElementById('floor_number').addEventListener('input', function() {
            let floorNumber = parseInt(this.value);
            let buildingName = "{{ $building->build_name }}"; // Get the building id
            let floorNumbers = {{ $building->floor_numbers }}; // Get the total number of floors
            let roomNumbers = {{ $building->room_numbers }}; // Get the total number of rooms

            if (floorNumber && floorNumber <= floorNumbers) {
                let roomsPerFloor = roomNumbers / floorNumbers;
                let roomNumber = Math.ceil(floorNumber * roomsPerFloor);
                let floorNumberStr = (floorNumber < 10) ? floorNumber.toString() : floorNumber.toString().padStart(2, '0');
                roomNumber = roomNumber < 10 ? '0' + roomNumber : roomNumber; // Add leading zero if needed
                let roomName = buildingName + '.' + floorNumberStr + roomNumber;

                // Set the generated room name to the input field
                document.getElementById('name').value = roomName;
            } else {
                document.getElementById('name').value = ''; // Clear room name if floor number is invalid
            }
        });

        function goBack() {
            window.location.href = "{{ route('buildings.index') }}";
        }
    </script>
    <script>
        function goBack() {
            window.location.href = "{{ route('buildings.index') }}";
        }
    </script>

    <style>
        .form-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form-group {
            flex: 0 0 30%;
            margin-bottom: 15px;
        }

        .form-group label {
            display: inline-block;
            font-weight: 600;
            color: #0E3B9C;
            font-family: Poppins;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: border 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
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
        .student-details {
            background-color:#c7d6fb ;
            border-radius: 10px;
            width: 100%;
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            margin-top: 10px;
            padding: 10px 0 0 0;
        }
        .info-left
        {
            margin-left: 25px;
        }
        .info-right{
            margin-right: 30px;
        }
    </style>
@endsection

{{--<x-app-layout>--}}
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-blue-700 leading-tight">--}}
{{--            {{ __('Create New Room') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="container">--}}
{{--        <h1 class="text-center my-4">Create New Room</h1>--}}

{{--        <form action="{{ route('rooms.store', $building->id) }}" method="POST">--}}
{{--            @csrf--}}

{{--            <div class="mb-4">--}}
{{--                <label for="building_id" class="block text-gray-700 font-bold mb-2">Building:</label>--}}
{{--                <input type="number" id="building_id" name="building_id" value="{{ $building->id }}" readonly--}}
{{--                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--            </div>--}}

{{--            <div class="mb-4">--}}
{{--                <label for="name" class="block text-gray-700 font-bold mb-2">Room Name:</label>--}}
{{--                <input type="text" id="name" name="name" required--}}
{{--                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--            </div>--}}

{{--            <div class="mb-4">--}}
{{--                <label for="floor_number" class="block text-gray-700 font-bold mb-2">Floor Number:</label>--}}
{{--                <input type="number" id="floor_number" name="floor_number" required--}}
{{--                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--            </div>--}}

{{--            <div class="mb-4">--}}
{{--                <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>--}}
{{--                <select id="type" name="type"--}}
{{--                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--                    <option value="">-- Select Type --</option>--}}
{{--                    @foreach ($distinctRoomTypes as $roomType)--}}
{{--                        <option value="{{ $roomType->type }}">{{ $roomType->type }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            <div class="mb-4">--}}
{{--                <label for="unit_price" class="block text-gray-700 font-bold mb-2">Unit Price:</label>--}}
{{--                <input type="number" id="unit_price" name="unit_price" required--}}
{{--                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
{{--            </div>--}}

{{--            <x-primary-button class="ms-4" type="submit">--}}
{{--                {{ __('Create Room') }}--}}
{{--            </x-primary-button>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <style>--}}
{{--        .container {--}}
{{--            max-width: 800px;--}}
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

{{--        .shadow {--}}
{{--            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);--}}
{{--        }--}}

{{--        .border {--}}
{{--            border: 1px solid #ccc;--}}
{{--        }--}}

{{--        .rounded {--}}
{{--            border-radius: 0.25rem;--}}
{{--        }--}}

{{--        .w-full {--}}
{{--            width: 100%;--}}
{{--        }--}}

{{--        .py-2 {--}}
{{--            padding-top: 0.5rem;--}}
{{--            padding-bottom: 0.5rem;--}}
{{--        }--}}

{{--        .px-3 {--}}
{{--            padding-left: 0.75rem;--}}
{{--            padding-right: 0.75rem;--}}
{{--        }--}}

{{--        .text-gray-700 {--}}
{{--            color: #4a5568;--}}
{{--        }--}}

{{--        .leading-tight {--}}
{{--            line-height: 1.25;--}}
{{--        }--}}

{{--        .focus\:outline-none {--}}
{{--            outline: 0;--}}
{{--        }--}}

{{--        .focus\:shadow-outline {--}}
{{--            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);--}}
{{--        }--}}

{{--        .mb-4 {--}}
{{--            margin-bottom: 1rem;--}}
{{--        }--}}

{{--        .font-bold {--}}
{{--            font-weight: 700;--}}
{{--        }--}}
{{--    </style>--}}
{{--</x-app-layout><?php--}}
