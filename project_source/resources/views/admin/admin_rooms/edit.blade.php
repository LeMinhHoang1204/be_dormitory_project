<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Create New Room') }}
        </h2>
    </x-slot>

    <div class="container">
        <h1 class="text-center my-4">Create New Room</h1>

        <form action="{{ route('rooms.update', [$building->id, $room->id]) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="building_id" class="block text-gray-700 font-bold mb-2">Building:</label>
                <input type="number" id="building_id" name="building_id" value="{{ $building->id }}" readonly
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Room Name:</label>
                <input type="text" id="name" name="name" value="{{ $room->name }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="floor_number" class="block text-gray-700 font-bold mb-2">Floor Number:</label>
                <input type="number" id="floor_number" name="floor_number" value="{{ $room->floor_number }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                <select id="type" name="type"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">-- Select Type --</option>
                    @foreach ($distinctRoomTypes as $roomType)
                        <option value="{{ $roomType->type }}" {{ $roomType->type == $room->type ? 'selected' : '' }}>
                            {{ $roomType->type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="unit_price" class="block text-gray-700 font-bold mb-2">Unit Price:</label>
                <input type="number" id="unit_price" name="unit_price" value="{{ $room->unit_price }}" required
                    step="0.01"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-bold mb-2">Unit Price:</label>
                <select id="status" name="status"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">-- Select status --</option>
                    <option value="1" {{ $room->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $room->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <x-primary-button class="ms-4" type="submit">
                {{ __('Update Room') }}
            </x-primary-button>
        </form>
    </div>

    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .text-center {
            text-align: center;
        }

        .my-4 {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .border {
            border: 1px solid #ccc;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .w-full {
            width: 100%;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .leading-tight {
            line-height: 1.25;
        }

        .focus\:outline-none {
            outline: 0;
        }

        .focus\:shadow-outline {
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .font-bold {
            font-weight: 700;
        }
    </style>
</x-app-layout><?php
