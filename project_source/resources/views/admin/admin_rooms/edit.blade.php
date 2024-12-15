@extends('Auth_.index')

<head>
    <title>Edit Room</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">
        <div class="bluefont">
            <h3>Edit Room</h3>
        </div>

        <p><strong>Building name:</strong> {{ $building->build_name }}</p>

        <form action="{{ route('rooms.update', [$building->id, $room->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-container">
                <div class="form-group">
                    <label for="building_id" class="block text-gray-700 font-bold mb-2">Building ID:</label>
                    <input type="number" id="building_id" name="building_id" value="{{ $building->id }}" readonly>
{{--                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
                </div>

                <div class="form-group">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Room Name:</label>
                    <input type="text" id="name" name="name" value="{{ $room->name }}" readonly>
{{--                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
                </div>
{{--                <div class="form-group">--}}
{{--                    <label for="name">Room Name:</label>--}}
{{--                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Room name will be generated" required readonly>--}}
{{--                    @error('name')--}}
{{--                    <div class="error">{{ $message }}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}

                <div class="form-group">
                    <label for="floor_number" class="block text-gray-700 font-bold mb-2">Floor Number:</label>
                    <input type="number" id="floor_number" name="floor_number" value="{{ $room->floor_number }}" readonly>
{{--                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">--}}
                </div>

                <div class="form-group">
                    <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                    <select id="type" name="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-- Select Type --</option>
                        @foreach ($distinctRoomTypes as $roomType)
                            <option value="{{ $roomType->type }}" {{ $roomType->type == $room->type ? 'selected' : '' }}>
                                {{ $roomType->type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="unit_price" class="block text-gray-700 font-bold mb-2">Unit Price:</label>
                    <input type="number" id="unit_price" name="unit_price" value="{{ $room->unit_price }}" required step="0.01"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="form-group">
                    <label for="status" class="block text-gray-700 font-bold mb-2">Status:</label>
                    <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-- Select status --</option>
                        <option value="1" {{ $room->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $room->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="assets" class="block text-gray-700 font-bold mb-2">Assets:</label>
                    <div id="assets-container">
                        @if($room->hasRoomAssets->isEmpty())
                            <p class="text-gray-500">No assets assigned to this room. Add new assets below:</p>
                        @else
                            @foreach ($room->hasRoomAssets as $asset)
                                <div class="asset-item">
                                    <label class="block text-gray-600 font-medium">{{ $asset->asset->name }}</label>
                                    <input type="number"
                                           name="assets[{{ $asset->asset->id }}]"
                                           value="{{ $asset->quantity }}"
                                           min="0"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           placeholder="Enter quantity">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
<div class="form-group">
                    <!-- Section for adding new assets -->
                    <div id="new-assets-container">
                        <h4 class="mt-4 text-gray-700 font-bold">Add New Assets</h4>
                        <div class="new-asset-item">
                            <label for="new_assets[]" class="block text-gray-600 font-medium">Asset:</label>
                            <select name="new_assets[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">-- Select Asset --</option>
                                @foreach($availableAssets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                                @endforeach
                            </select>
                            <label for="new_quantities[]" class="block text-gray-600 font-medium mt-2">Quantity:</label>
                            <input type="number" name="new_quantities[]" value="1" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter quantity">
                        </div>
                    </div>
                    <button type="button" id="add-asset" class="mt-2 text-blue-500">+ Add another asset</button>
                </div>
                <script>
                    // JavaScript to dynamically add new asset inputs
                    document.getElementById('add-asset').addEventListener('click', function() {
                        const container = document.getElementById('new-assets-container');
                        const newAssetItem = document.querySelector('.new-asset-item').cloneNode(true);
                        container.appendChild(newAssetItem);
                    });
                </script>


            </div>
            <div class="form-actions">
                <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>
                <button type="submit" class="blue-btn">Update Room</button>
            </div>

            <script>
                function goBack() {
                    window.location.href = "{{ route('buildings.show', $building->id) }}";
                }
            </script>
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
            flex: 0 0 48%;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #0E3B9C;
            font-family: Poppins;
        }

        .form-group select,
        .form-group input {
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
    </style>
@endsection
