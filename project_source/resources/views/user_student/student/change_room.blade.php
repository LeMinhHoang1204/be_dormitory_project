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

@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const error = @json(session('error'));
            // Display the notification
            toastr.warning(
                `${error.message}`
            );
        });
    </script>
@endif

<head>
    <title>Room Change</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">

    {{-- WEBSITE: tabler icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>

    {{-- WEBSITE: toastr --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('./css/reg_room.css') }}" type="text/css">
    <script src="{{ asset('./javascript/reg_room.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <div class="header-container">
                <h1 class="title">Room Change</h1>
                <div class="header-controls">
                    {{-- Button filter --}}
                <div class="filter-icon" onclick="toggleFilter()">
                    <i class="ti ti-adjustments-horizontal"></i>
                </div>

                {{-- Search bar --}}
                <div class="search-bar">
                    <input type="text" placeholder="Search rooms..." class="search-input"
                           onkeyup="handleSearchKeyup(event)" autocomplete="off" aria-label="Search rooms">
                </div>
            </div>
        </div>

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
                                    onclick="handleRegisterClick(event, {{ $room->id }}, true)">Change</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <!-- Pagination -->
    <div class="pagination">
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
                    <a href="{{ $rooms->url($i) }}" class="pagination-page">{{ $i }}</a>
                @endif
            @endfor
        @else
            @if ($currentPage > 3)
                <a href="{{ $rooms->url(1) }}" class="pagination-page">1</a>
                <span class="ellipsis">...</span>
            @endif

            @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
                @if ($i == $currentPage)
                    <span class="pagination-page current">{{ $i }}</span>
                @else
                    <a href="{{ $rooms->url($i) }}" class="pagination-page">{{ $i }}</a>
                @endif
            @endfor

            @if ($currentPage < $lastPage - 2)
                <span class="ellipsis">...</span>
                <a href="{{ $rooms->url($lastPage) }}" class="pagination-page">{{ $lastPage }}</a>
            @endif
        @endif

        @if ($rooms->hasMorePages())
            <a href="{{ $rooms->nextPageUrl() }}" class="next">Next</a>
        @else
            <span class="gap">Next</span>
        @endif
    </div>

@endsection

<!-- Modal Filter Popup -->
<div id="filter-popup" class="filter-popup">
    <div class="filter-popup-content">
        <div class="filter-container">
            <!-- Room Status -->
            <div class="filter-group">
                <h3>Room Status</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Vacancy</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Full</span>
                    </label>
                </div>
            </div>

            <!-- Building Type -->
            <div class="filter-group">
                <h3>Building Type</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Male</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Female</span>
                    </label>
                </div>
            </div>

            <!-- Floor Number -->
            <div class="filter-group">
                <h3>Floor Number</h3>
                <div class="select-wrapper">
                    <select class="floor-select">
                        <option value="">Choose a floor</option>
                        <option value="1">Floor 1</option>
                        <option value="2">Floor 2</option>
                        <option value="3">Floor 3</option>
                        <option value="4">Floor 4</option>
                        <option value="5">Floor 5</option>
                    </select>
                </div>
            </div>

            <!-- Room Type -->
            <div class="filter-group">
                <h3>Room Type</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">1 person</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">2 people</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">4 people</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">6 people</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">8 people</span>
                    </label>
                </div>
            </div>

            <!-- Price -->
            <div class="filter-group">
                <h3>Price</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">
                            < 500.000 VND</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">
                            < 1.000.000 VND</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">
                            < 2.000.000 VND</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">
                            < 3.000.000 VND</span>
                    </label>
                </div>
            </div>

            <!-- Facilities -->
            <div class="filter-group">
                <h3>Facilities</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Fridge</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Washing machine</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Air-Conditioner</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Water heater</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <span class="label-text">Study desk</span>
                    </label>
                </div>
            </div>

            <!-- Button -->
            <div class="button-group">
                <button type="button" class="btn btn-secondary cancel-btn" onclick="closePopup()">Cancel</button>
                <button class="btn btn-primary apply-btn">Apply</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirm Register -->
<div id="confirm-register-modal" class="register-popup">
    <div class="register-popup-content">
        <div class="popup-header">
            <h2>Confirm Change</h2>
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
            <h2>Room Change</h2>
        </div>
        <div class="popup-body">
            <form action="{{ route('students.change-room-store') }}" method="POST" id="registration-form">
                @csrf
                <input type="hidden" id="room-id-input" name="room_id" value="{{$room->id}}">
                <input type="hidden" id="request-type" name="type" value="Change Room">
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
                                <span class="label-text">Capacity: </span>
                                <span class="room-detail" id="display-room-capacity"></span>
                            </div>
                        </div>
                    </div>

                    <div class="description">
                        <div class="form-field">
                            <label>Reason for change:</label>
                            <textarea name="reason" class="form-control" rows="3" placeholder="Enter any additional reasons" required></textarea>
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


<script src="{{ asset('./javascript/reg_room.js') }}"></script>
