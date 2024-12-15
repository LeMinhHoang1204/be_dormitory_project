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
{{--                <!-- Room Name -->--}}
{{--                <div class="form-group">--}}
{{--                    <label for="name">Room Name:</label>--}}
{{--                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter room name" required>--}}
{{--                    @error('name')--}}
{{--                    <div class="error">{{ $message }}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}

{{--                <!-- Floor Number -->--}}
{{--                <div class="form-group">--}}
{{--                    <label for="floor_number">Floor Number:</label>--}}
{{--                    <input type="number" id="floor_number" name="floor_number" value="{{ old('floor_number') }}" min="1" required>--}}
{{--                    @error('floor_number')--}}
{{--                    <div class="error">{{ $message }}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}


                <div class="form-group">
                    <label for="floor_number">Floor Number:</label>
                    <input type="number" id="floor_number" name="floor_number" value="{{ old('floor_number') }}" min="1"  placeholder="Enter floor number of the room" required>
                    @error('floor_number')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Room Name:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Room name will be generated" required>
                    <div id="name-error" class="error" style="display: none; color: red;">Room name already exists. Please choose another name.</div>
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
            <div class="form-group">
                <label for="assets">Select Assets:</label>
                <div id="asset-container" class="asset-container">
                    @foreach ($assets as $asset)
                        <div class="asset-item">
                            <div class="asset-checkbox">
                                <input
                                    type="checkbox"
                                    id="asset_{{ $asset->id }}"
                                    name="assets[{{ $asset->id }}]"
                                    value="{{ $asset->id }}">
                                <label for="asset_{{ $asset->id }}">{{ $asset->name }}</label>
                            </div>
                            <div class="asset-quantity">
                                <input
                                    type="number"
                                    name="assets_quantity[{{ $asset->id }}]"
                                    min="0"
                                    placeholder="Quantity"
                                    class="asset-quantity-input"
                                    disabled>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-actions">
                <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>
                    <button type="submit" class="blue-btn">Create Room</button>
            </div>
        </form>
    </div>
<script>
    document.querySelectorAll('.asset-item input[type="checkbox"]').forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            const quantityInput = this.parentElement.nextElementSibling.querySelector('.asset-quantity-input');
            if (this.checked) {
                quantityInput.disabled = false;
                quantityInput.required = true;
            } else {
                quantityInput.disabled = true;
                quantityInput.required = false;
                quantityInput.value = ''; // Clear quantity
            }
        });
    });


</script>
    <script>
        document.getElementById('floor_number').addEventListener('input', function() {
            let floorNumber = parseInt(this.value);
            let buildingName = "{{ $building->build_name }}";
            // let roomName = '';
            let roomNameInput = document.getElementById('name');
            let maxFloors = {{ $building->floor_numbers }};
            if (floorNumber && floorNumber > 0 && floorNumber <= maxFloors) {
                let floorNumberStr = (floorNumber < 10) ?  + floorNumber : floorNumber.toString();
                // roomName = buildingName + '.' + floorNumberStr;
                let fullRoomName = buildingName + '.' + floorNumberStr;
                roomNameInput.value = fullRoomName;
                roomNameInput.readOnly = false;
                // document.getElementById('name').value = roomName;
            } else {
                // document.getElementById('name').value = '';
                roomNameInput.value = "No floor default";
                roomNameInput.readOnly = true;
            }
        });

        document.getElementById('name').addEventListener('input', function() {
            let roomName = this.value.trim();
            let floorNumber = document.getElementById('floor_number').value;
            let buildingName = "{{ $building->build_name }}";
            if (roomName && roomName.indexOf(buildingName + '.' + floorNumber) === 0) {
                document.getElementById('name').value = roomName;

                checkRoomNameExists(roomName);
            }
            // else {
            //     // Nếu không có tầng hợp lệ, xóa tên phòng
            //     document.getElementById('name').value = '';
            //     document.getElementById('name-error').style.display = 'none';
            // }


        });
        function checkRoomNameExists(roomName) {
            fetch('/check-room-name', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ name: roomName })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        document.getElementById('name-error').style.display = 'block'; // Hiển thị thông báo lỗi
                    } else {
                        document.getElementById('name-error').style.display = 'none'; // Ẩn thông báo lỗi
                    }
                })
                .catch(error => console.error('Error checking room name:', error));
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
        .asset-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Tạo các cột linh hoạt */
            gap: 10px;
            padding: 5px 0;
        }

        .asset-item {
            background: #fff;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
            border: 1px solid #ddd; /* Viền mỏng xung quanh */
        }

        .asset-item:hover {
            background-color: #f0f8ff;
        }

        .asset-checkbox {
            display: flex;
            align-items: center;
            /*gap: 10px;*/
            /*width: fit-content;*/
        }

        .asset-checkbox input {
            margin-right: 10px;
            width: 15px;
            height: 20px;
            text-align: center;
        }

        .asset-checkbox label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .asset-quantity {
            width: 100px;
            height: 27px;
            display: flex;
            justify-content: flex-end;
        }

        .asset-quantity-input {
            /*width: 80px;*/
            /*padding: 5px;*/
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f7f7f7;
            text-align: center;
        }

        .asset-quantity-input:disabled {
            background-color: #e0e0e0;
        }

        .asset-item input[type="checkbox"]:checked + label {
            color: #4a90e2; /* Màu chữ khi checkbox được chọn */
        }

        .asset-item input[type="checkbox"]:checked + label + .asset-quantity input {
            background-color: #fff; /* Màu nền của input khi checkbox được chọn */
            border-color: #4a90e2; /* Viền màu xanh khi checkbox được chọn */
        }

        .asset-item input[type="checkbox"]:not(:checked) + label + .asset-quantity input {
            background-color: #e0e0e0; /* Màu nền xám khi checkbox chưa được chọn */
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
