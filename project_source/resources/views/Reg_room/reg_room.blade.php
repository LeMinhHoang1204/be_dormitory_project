@extends('Auth_.index')

@if (session('notification'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const notification = @json(session('notification'));
            // Display the notification
            toastr.info(
                `${notification.message} `
            );
        });
    </script>
@endif

<head>
    <title>Room Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">

    {{-- WEBSITE: tabler icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>

    {{-- WEBSITE: toastr --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('./css/reg_room.css') }}" type="text/css">
    <script src="{{ asset('./javascript/reg_room.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>

<style>
    .toast-warning {
        color: #ffffff !important; /* Text color for warning notification */
        background-color: #ffc107 !important; /* Background color */
        font-family: "Poppins", sans-serif !important; /* Font family */
        border-left: 5px solid #ff9800 !important; /* Left border color */
    }

    .toast-info {
        color: #ffffff !important; /* Màu chữ cho thông báo thông tin */
        background-color: #17a2b8 !important; /* Màu nền */
        font-family: "Poppins", sans-serif !important; /* Font chữ */
    }
</style>

@section('content')
    @include('layouts.sidebar_student')
    <div class="container">
        <x-header-search title="Room Registration" />
        <div class="residence-container">
            <a href="{{ asset('./pdf/mau-xac-nhan-thong-tin-ve-cu-tru-ct-07_0112100225.pdf') }}" class="residence-link" target="_blank">
                <i class="ti ti-id-badge"></i>
                Residence Confirmation
            </a>
        </div>
    </div>

    @if(!$rooms->isEmpty())
        <div class="grid-container" id="room-list">
            @foreach ($rooms as $room)
                <div class="room-item" onclick="redirectToRoomInfo({{ $room->id }})"
                     data-floor="{{ $room->floor_number }}" data-type="{{ $room->type }}"
                     data-capacity="{{ $room->member_count }}">
                    <img src="/img/room.png">
                    <div class="room-item-group">
                        <div class="roomname">{{ $room->name }}</div>
                        <div id="room-price">
                            <span class="price">{{ $room->unit_price }}₫</span>
                            <span class="per-month">/month</span>
                        </div>
                        <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>
                        <div class="type-group">
                            @foreach ($room->hasRoomAssets as $asset)
                                <span class="detail-item">
                                    @php
                                        $iconMap = [
                                            'bed' => 'bed',
                                            'table' => 'desk',
                                            'chair' => 'armchair',
                                            'fan' => 'propeller',
                                            'air conditioner' => 'air-conditioning',
                                            'fridge' => 'fridge',
                                        ];
                                        $icon = $iconMap[strtolower($asset->asset->name)] ?? 'box';
                                    @endphp
                                    <i class="ti ti-{{ $icon }}"></i>
                                    {{ $asset->quantity }}
                                </span>
                            @endforeach
                            <button class="change-button"
                                    onclick="handleRegisterClick(event, {{ $room->id }})">Register</button>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @else
        <div class="no-result" style="margin-top: 40px; text-align: center">
            <h2>No rooms found</h2>
            <p>There are no rooms that match your search</p>
        </div>
    @endif



    <!-- Pagination -->
            <div class="pagination">
{{--                {{ $rooms->appends(request()->except('page'))->links() }}--}}

            @if ($rooms->onFirstPage())
                    <span class="gap">Previous</span>
                @else
                    <a href="{{ $rooms->previousPageUrl() }}" class="previous">Previous</a>
                @endif

                @php
                    $currentPage = $rooms->currentPage();
                    $lastPage = $rooms->lastPage();
                @endphp

                    <!-- Nếu số trang ít hơn hoặc bằng 5, hiển thị tất cả các trang -->
                @if ($lastPage <= 5)
                    @for ($i = 1; $i <= $lastPage; $i++)
                        @if ($i == $currentPage)
                            <span class="pagination-page current">{{ $i }}</span>
                        @else
                            <a href="{{ $rooms->appends(request()->all())->url($i) }}" class="pagination-page">{{ $i }}</a>
                        @endif
                    @endfor
                @else
                    @if ($currentPage > 3)
                        <a href="{{ $rooms->appends(request()->all())->url(1) }}" class="pagination-page">1</a>
                        <span class="ellipsis">...</span>
                    @endif

                    @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
                        @if ($i == $currentPage)
                            <span class="pagination-page current">{{ $i }}</span>
                        @else
                            <a href="{{ $rooms->appends(request()->all())->url($i) }}" class="pagination-page">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($currentPage < $lastPage - 2)
                        <span class="ellipsis">...</span>
                        <a href="{{ $rooms->appends(request()->all())->url($lastPage) }}" class="pagination-page">{{ $lastPage }}</a>
                    @endif
                @endif

                @if ($rooms->hasMorePages())
                    <a href="{{ $rooms->nextPageUrl() }}" class="next">Next</a>
                @else
                    <span class="gap">Next</span>
                @endif
            </div>


        @endsection
        <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelector('.apply-btn').addEventListener('click', function(event, roomId) {
                document.getElementById("room-id-input-filter").value = roomId;

                event.preventDefault();

                const status = [];
                document.querySelectorAll('input[type="checkbox"][name="status[]"]:checked').forEach(function(checkbox) {
                    status.push(checkbox.value);
                });

                const buildingType = [];
                document.querySelectorAll('input[type="checkbox"][name="buildingType[]"]:checked').forEach(function(checkbox) {
                    buildingType.push(checkbox.value);
                });

                const floorNumber = document.querySelector('select[name="floorNumber"]').value;
                const roomType = [];
                document.querySelectorAll('input[type="checkbox"][name="roomType[]"]:checked').forEach(function(checkbox) {
                    roomType.push(checkbox.value);
                });

                const price = [];
                document.querySelectorAll('input[type="checkbox"][name="price[]"]:checked').forEach(function(checkbox) {
                    price.push(checkbox.value);
                });

                const facilities = [];
                document.querySelectorAll('input[type="checkbox"][name="facilities[]"]:checked').forEach(function(checkbox) {
                    facilities.push(checkbox.value);
                });

                // Lấy giá trị của trang hiện tại nếu có
                const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

                // Tạo URL với các tham số lọc và trang hiện tại
                let filterParams = `?status=${status.length ? status.join(',') : ''}&buildingType=${buildingType.length ? buildingType.join(',') : ''}&floorNumber=${floorNumber || ''}&roomType=${roomType.length ? roomType.join(',') : ''}&price=${price.length ? price.join(',') : ''}&facilities=${facilities.length ? facilities.join(',') : ''}&page=${currentPage}`;

                // Thực hiện gửi URL với các tham số lọc
                window.location.href = `{{ route('students.filter-rooms') }}${filterParams}`;
            });
        });
        </script>

<!-- Modal Filter Popup -->
<div id="filter-popup" class="filter-popup">
    <div class="filter-popup-content">
    <form action="{{ route('students.filter-rooms') }}" method="GET">
    @csrf
    <div class="filter-container">

        <input type="hidden" name="room_id" value="{{ $room_id ?? '' }}">

        <div class="filter-group">
            <h3>Room Status</h3>
            <div class="checkbox-list">
                <label class="checkbox-item">
                    <input type="checkbox" name="status[]" value="1" checked>
                    <span class="checkmark"></span>
                    <span class="label-text">Vacancy</span>
                </label>
            </div>
        </div>

        @if ($userGender)
            <div class="filter-group">
                <h3>Building Type</h3>
                <label class="checkbox-item">
                    <input type="checkbox" value="{{ $userGender }}"
                           name="buildingType[]"
                           readonly
                           checked
                    >
                    <span class="checkmark"></span>
                    <span class="label-text">{{ ucfirst($userGender) }}</span>
                </label>
            </div>
        @else
            <div class="filter-group">
                <h3>Building Type</h3>
                <label class="checkbox-item">
                    <input type="checkbox" value="female"
                           name="buildingType[]">
                    <span class="checkmark"></span>
                    <span class="label-text">Female</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" value="male"
                           name="buildingType[]">
                    <span class="checkmark"></span>
                    <span class="label-text">Male</span>
                </label>
            </div>
        @endif

        <div class="filter-group">
            <h3>Floor Number</h3>
            <div class="select-wrapper">
                <select name="floorNumber" class="floor-select">
                    <option value="">Choose a floor</option>
                    @for ($i = 1; $i <= 20; $i++)
                        <option value="{{ $i }}">Floor {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="filter-group">
            <h3>Room Type</h3>
            @foreach ([2, 4, 6, 8, 10] as $people)
                <label class="checkbox-item">
                    <input type="checkbox" name="roomType[]" value="{{ $people }}">
                    <span class="checkmark"></span>
                    <span class="label-text">{{ $people }} people</span>
                </label>
            @endforeach
        </div>

        <div class="filter-group">
            <h3>Price (VNĐ)</h3>
            @foreach ([ 1 => '< 1.000.000', 2 => '1.000.000 - 1.500.000', 3 => '1.500.000 - 2.000.000', 4 => '2.000.000 - 2.500.000', 5 => '> 2.500.000'] as $value => $label)
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="{{ $value }}">
                    <span class="checkmark"></span>
                    <span class="label-text">{{ $label }}</span>
                </label>
            @endforeach
        </div>

        <div class="filter-group">
            <h3>Facilities</h3>
            @foreach (['air conditioner', 'fridge', 'water heater', 'television'] as $facility)
                <label class="checkbox-item">
                    <input type="checkbox" name="facilities[]" value="{{ $facility }}">
                    <span class="checkmark"></span>
                    <span class="label-text">{{ ucfirst($facility) }}</span>
                </label>
            @endforeach
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="button" class="btn btn-secondary cancel-btn" onclick="closePopup()">Cancel</button>
            <button type="submit" class="btn btn-primary apply-btn">Apply</button>
        </div>
    </div>
</form>
    </div>
</div>

<!-- Modal Confirm Register -->
<div id="confirm-register-modal" class="register-popup">
    <div class="register-popup-content">
        <div class="popup-header">
            <h2>Confirm Registration</h2>
        </div>
        <div class="popup-body">
            <p>Are you sure you want to register for this room?</p>
            <div class="button-group mt-4">
                <button type="button" class="btn btn-secondary" onclick="closeConfirmModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="proceedToRegistration()">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Register Popup -->
<div id="register-popup" class="register-popup">
    <div class="register-popup-content">
        <div class="popup-header">
            <h2>Room Registration</h2>
        </div>
        <div class="popup-body">
            <form action="{{ route('students.register-room.create') }}" method="POST" id="registration-form"
                  onsubmit="return handleFormSubmit(event)">
                @csrf
                <input type="hidden" id="room-id-input" name="room_id">

                <div class="form-group">
                    <div class="room-info-display">
                        <div class="info-column">
                            <div class="info-item">
                                <span class="label-text">Room: </span>
                                <span class="room-detail" id="display-room-name"></span>
                            </div>
                            <div class="info-item">
                                <span class="label-text">Price: </span>
                                <span class="room-detail" id="display-room-price"></span>
                            </div>
                            <div class="info-item">
                                <span class="label-text">Floor number: </span>
                                <span class="room-detail" id="display-floor-number"></span>
                            </div>
                        </div>

                        <div class="info-column">
                            <div class="info-item">
                                <span class="label-text">Type: </span>
                                <span class="room-detail" id="display-room-type"></span>
                            </div>
                            <div class="info-item">
                                <span class="label-text">Members: </span>
                                <span class="room-detail" id="display-room-capacity"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-fields-row">
                        <div class="form-field">
                            <label>Check-in Date:</label>
                            <input type="datetime-local" name="check_in_date" class="form-control" required>
                        </div>

                        <div class="form-field">
                            <label>Duration (months):</label>
                            <select name="duration" class="form-control" required>
                                <option value="3">3 months</option>
                                <option value="6">6 months</option>
                                <option value="9">9 months</option>
                                <option value="12">12 months</option>
                            </select>
                        </div>
                    </div>
                    <div class="description">
                        <div class="form-field">
                            <label>Note:</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Enter any additional notes"></textarea>
                        </div>
                    </div>
                </div>

                <div class="button-group mt-4">
                    <button type="button" class="btn btn-secondary" onclick="closePopup()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Agree</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal payment info -->
<div id="payment-info-modal" class="register-popup">
    <div class="register-popup-content">
        <div class="popup-header">
            <h2>Payment Information</h2>
        </div>
        <div class="popup-body">
            <div class="payment-info">
                <div class="payment-alert">
                    <i class="ti ti-alert-circle"></i>
                    <p>Please complete your payment within <strong>7 days</strong> to confirm your registration</p>
                </div>

                <div class="payment-details">
                    <div class="info-row">
                        <span class="label">Total Amount:</span>
                        <span class="value" id="payment-amount"></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Due Date:</span>
                        <span class="value" id="payment-due-date"></span>
                    </div>
                </div>

                <div class="bank-details">
                    <h3>Bank Transfer Information</h3>
                    <div class="bank-info">
                        <div class="info-row">
                            <span class="label">Bank Name:</span>
                            <span class="value">VietcomBank</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Account Number:</span>
                            <span class="value">1234567890</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Account Holder:</span>
                            <span class="value">DORMITORY MANAGEMENT</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Transfer Description:</span>
                            <span class="value">ROOM_[Room Number]_[Student ID]</span>
                        </div>
                    </div>
                </div>

                <div class="payment-note">
                    <i class="ti ti-info-circle"></i>
                    <p>After completing the payment, please keep your transfer receipt for verification purposes.</p>
                </div>
            </div>

            <div class="button-group mt-4">
                <button type="button" class="btn btn-secondary" onclick="closePopup()">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadPaymentInfo()">Download Info</button>
            </div>
        </div>
    </div>
</div>



<!-- Thong bao -->
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33',
        });
    </script>
@endif
<script src="{{ asset('./javascript/reg_room.js') }}"></script>
