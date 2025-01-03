{{-- resources/views/notifications/create.blade.php --}}
@extends('Auth_.index')

<head>
    <title>Create Notification</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/Notification/notification.css') }}" type="text/css">
    <script src="{{ asset('./javascript/notification/notification.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('a42fc293e9345264b282', {
            cluster: 'ap1'
        });
        var channel = pusher.subscribe('be-dormitory-channel');
        channel.bind('user-login', function(data) {
            toastr.success(JSON.stringify(data.email) + ' has joined our website');
        });
    </script>
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="notification-form">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-white">
                    <i class="fas fa-plus-circle me-2"></i>{{ __('Create New Notification') }}
                </h4>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('notifications.store') }}" method="POST" id="notificationForm">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control readonly-field" id="sender_id" name="sender_id"
                            value="{{ auth()->user()->id }}" readonly>
                        <label for="sender_id">Sender ID</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="object_id" name="object_id"
                            value="{{ old('object_id') }}" required>
                        <label for="object_id">Object ID</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                            required>
                        <label for="title">Title</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="type" name="type" required>
                            <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>
                                Individual
                            </option>
                            <option value="group" {{ old('type') == 'group' ? 'selected' : '' }}>
                                Group
                            </option>
                        </select>
                        <label for="type">Notification Type</label>
                    </div>


                    {{-- User Selection --}}
                    <div class="form-floating mb-3" id="userSelection" style="display: none;">
                        <select class="form-select" id="user_object_id" name="user_object_id" data-live-search="true">
                            <option value="">Select User</option>
                        </select>
                        <label for="user_object_id">Select User</label>
                    </div>

                    <div id="groupOptions" style="display: none;">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="group" name="group">
                                <option value="building">Building</option>
                            </select>
                            <label for="group">Group Type</label>
                        </div>

                        <div class="form-floating mb-3" id="buildingSelection" style="display: none;">
                            <select name="building_object_id" id="building_object_id" class="form-select">
                                <option value="">Select Building</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}">{{ $building->build_name }}</option>
                                @endforeach
                            </select>
                            <label for="building_object_id">Select Building</label>
                        </div>

                        <div class="form-floating mb-3" id="roomSelection" style="display: none;">
                            <select class="form-select" id="room_object_id" name="room_object_id">
                                <option value="">Select Room</option>
                            </select>
                            <label for="room_object_id">Select Room</label>
                        </div>

                        <div class="mb-3" id="roomUsersSelection" style="display: none;">
                            <label class="form-label">Select Users in Room</label>
                            <div class="user-selection-container border rounded p-3">
                                <div class="row" id="room_users_checkboxes">
                                    <!-- Checkboxes will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <textarea class="form-control" id="content" name="content" style="height: 150px" required>{{ old('content') }}</textarea>
                        <label for="content">Content</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>{{ __('Create Notification') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            // Load users when page loads
            $.get('/get-all-users', function(users) {
                users.forEach(function(user) {
                    $('#user_object_id').append(new Option(user.name, user.id));
                });
            });

            // Load buildings when page loads
            $.get('/get-all-buildings', function(buildings) {
                buildings.forEach(function(building) {
                    $('#building_object_id').append(new Option(building.build_name, building.id));
                });
            });

            // Handle notification type change
            $('#type').change(function() {
                if ($(this).val() === 'individual') {
                    $('#userSelection').show();
                    $('#groupOptions').hide();
                } else if ($(this).val() === 'group') {
                    $('#userSelection').hide();
                    $('#groupOptions').show();
                    $('#buildingSelection').show();
                }
            });

            // Handle group type change
            $('#group').change(function() {
                if ($(this).val() === 'building') {
                    $('#buildingSelection').show();
                    $('#roomSelection').hide();
                } else if ($(this).val() === 'room') {
                    $('#buildingSelection').show();
                    $('#roomSelection').show();
                }
            });

            // Handle building selection change
            $('#building_object_id').change(function() {
                const buildingId = $(this).val();
                console.log('Selected building ID:', buildingId);

                const roomSelect = $('#room_object_id');
                roomSelect.empty().append('<option value="">Select Room</option>');

                if (buildingId) {
                    const url = `/get-rooms-by-building/${buildingId}`;
                    console.log('Fetching rooms from:', url);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            console.log('Received response:', response);
                            response.forEach(function(room) {
                                console.log('Adding room:', room);
                                roomSelect.append(
                                    `<option value="${room.id}">${room.name}</option>`
                                );
                            });
                            $('#roomSelection').show();
                        },
                        error: function(error) {
                            console.error('Error details:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Failed to load rooms. Please try again later.',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    $('#roomSelection').hide();
                }
            });

            // Handle room selection change
            $('#room_object_id').change(function() {
                const roomId = $(this).val();
                const userCheckboxesContainer = $('#room_users_checkboxes');
                userCheckboxesContainer.empty();

                if (roomId) {
                    $.ajax({
                        url: `/get-users-by-room/${roomId}`,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (Array.isArray(response) && response.length > 0) {
                                response.forEach(function(user) {
                                    const checkboxDiv = `
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="room_users[]"
                                                       value="${user.id}"
                                                       id="user_${user.id}">
                                                <label class="form-check-label" for="user_${user.id}">
                                                    ${user.name}
                                                </label>
                                            </div>
                                        </div>
                                    `;
                                    userCheckboxesContainer.append(checkboxDiv);
                                });
                                $('#roomUsersSelection').show();
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'No Users Found',
                                    text: 'There are no users registered in this room.',
                                    confirmButtonColor: '#3085d6',
                                });
                                $('#roomUsersSelection').hide();
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Failed to load users. Please try again later.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage,
                                confirmButtonColor: '#d33',
                            });
                            $('#roomUsersSelection').hide();
                        }
                    });
                } else {
                    $('#roomUsersSelection').hide();
                }
            });

            // Add this new code for form submission
            $('#notificationForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Notification created successfully',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    "{{ route('notifications.index') }}";
                            }
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Something went wrong. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonColor: '#d33',
                        });
                    }
                });
            });
        });
    </script>

    <style>
        .user-selection-container {
            max-height: 300px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .form-check-label {
            cursor: pointer;
        }

        .form-check-input:checked+.form-check-label {
            color: #0d6efd;
            font-weight: 500;
        }
    </style>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">
