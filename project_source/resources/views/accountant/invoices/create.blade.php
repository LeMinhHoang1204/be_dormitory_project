@extends('Auth_.index')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/payment.css') }}" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Create Invoice</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('invoices.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" disabled selected>Select Type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="total" class="form-label">Total</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="total" name="total" required>
                                <span class="input-group-text">VND</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{--                        <div class="col-md-6 mb-3"> --}}
                        {{--                            <label for="payment_method" class="form-label">Payment Method</label> --}}
                        {{--                            <select class="form-select" id="payment_method" name="payment_method" required> --}}
                        {{--                                <option value="" disabled selected>Select Payment Method</option> --}}
                        {{--                                @foreach ($payment_methods as $method) --}}
                        {{--                                    <option value="{{ $method }}">{{ $method }}</option> --}}
                        {{--                                @endforeach --}}
                        {{--                            </select> --}}
                        {{--                        </div> --}}
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="receiver_id" class="form-label">Object ID</label>
                            <input type="text" class="form-control" id="receiver_id" name="receiver_id" required>
                        </div>
                    </div>


                    <div class="form-floating mb-3">
                        <select class="form-select" id="sendTo" name="sendTo" required>
                            <option value="" disabled selected>Select Send To</option>
                            <option value="individual" {{ old('sendTo') == 'individual' ? 'selected' : '' }}>
                                Individual
                            </option>
                            <option value="group" {{ old('sendTo') == 'group' ? 'selected' : '' }}>
                                Group
                            </option>
                        </select>
                        <label for="sendTo">Send To</label>
                    </div>


                    {{-- User Selection --}}
                    <div class="form-floating mb-3" id="userSelection" style="display: none;">
                        <input type="number" class="form-control" id="user_object_id" name="user_object_id"
                            placeholder="Enter User ID">
                        <label for="user_object_id">Enter User ID</label>
                        <div id="userName" class="form-text mt-2" style="display: none;">
                            User Name: <span id="userNameText" class="fw-bold"></span>
                        </div>
                    </div>

                    <div id="groupOptions" style="display: none;">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="group" name="group">
                                <option value="" disabled selected>Select Group Type</option>
                                <option value="building">Building</option>
                                <option value="room">Room</option>
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
                                    <!-- Checkboxes -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h4 class="mb-0">Payment Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Bank name: <strong>ViettinBank</strong></p>
                                    <p>Account name: <strong>LaravelDormitory</strong></p>
                                    <p>Account number: <strong>12317477231</strong></p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p>Scan to Pay:</p>
                                    <img src="{{ asset('images/qrcode.png') }}" alt="QR Code" class="img-fluid"
                                        style="max-width: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.get('/get-all-buildings', function(buildings) {
                buildings.forEach(function(building) {
                    $('#building_object_id').append(new Option(building.build_name, building.id));
                });
            });

            $('#sendTo').change(function() {
                if ($(this).val() === 'individual') {
                    $('#userSelection').show();
                    $('#groupOptions').hide();
                } else if ($(this).val() === 'group') {
                    $('#userSelection').hide();
                    $('#groupOptions').show();
                    $('#buildingSelection').show();
                }
            });

            $('#group').change(function() {
                if ($(this).val() === 'building') {
                    $('#buildingSelection').show();
                    $('#roomSelection').hide();
                } else if ($(this).val() === 'room') {
                    $('#buildingSelection').show();
                    $('#roomSelection').show();
                }
            });

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

            $('#room_object_id').change(function() {
                const roomId = $(this).val();
                console.log('Selected room ID:', roomId);

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

            // Bắt sự kiện submit form
            $('form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Invoice created successfully',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Chuyển hướng về trang invoice
                                window.location.href = "{{ route('invoices.index') }}";
                            }
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Something went wrong. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Lấy tất cả các lỗi validation và nối chúng lại
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join(
                                '\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errorMessage,
                            confirmButtonColor: '#d33',
                        });
                    }
                });
            });

            // Add this new function to handle user ID input
            $('#user_object_id').on('change', function() {
                const userId = $(this).val();
                if (userId) {
                    // Call API to get user info
                    $.ajax({
                        url: `/get-user-info/${userId}`,
                        method: 'GET',
                        success: function(response) {
                            if (response.name) {
                                $('#userNameText').text(response.name);
                                $('#userName').show();
                            } else {
                                $('#userName').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'User Not Found',
                                    text: 'No user found with this ID',
                                    confirmButtonColor: '#d33',
                                });
                            }
                        },
                        error: function() {
                            $('#userName').hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch user information',
                                confirmButtonColor: '#d33',
                            });
                        }
                    });
                } else {
                    $('#userName').hide();
                }
            });
        });
    </script>
@endsection

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
