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

    {{-- WEBSITE: tabler icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Enable pusher logging - don't include this in production
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
                <form action="{{ route('notifications.store') }}" method="POST">
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
                    
                    {{-- <div class="form-floating mb-3" id="userSelection" style="display: none;">
                        <select class="form-select" id="user_object_id" name="user_object_id">
                            <option value="">Select User</option>
                        </select>
                        <label for="user_object_id">Select User</label>
                    </div> --}}

                    <div id="groupOptions" style="display: none;">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="group" name="group">
                                <option value="building">Building</option>
                                {{-- <option value="room">Room</option> --}}
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
            $('form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Notification created successfully',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    "{{ route('notifications.index') }}";
                            }
                        });
                    },
                    error: function(xhr) {
                        let errorMessage =
                            'An error occurred while creating the notification. Please try again!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });

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
                            toastr.error('Failed to load rooms. Please try again.');
                        }
                    });
                } else {
                    $('#roomSelection').hide();
                }
            });
        });
    </script>
@endsection
