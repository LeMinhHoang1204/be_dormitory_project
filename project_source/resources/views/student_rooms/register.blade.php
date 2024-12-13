@extends('Auth_.index')

<head>
    <title>Room Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/register.css') }}" type="text/css">
    <script src="{{ asset('./javascript/register.js') }}"></script>
</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="container">
        <div class="header-container">
            <h1 class="title">Room Registration</h1>
            <div class="header-controls">
                {{-- Button filter --}}
                <div class="filter-icon" onclick="toggleFilter()">
                    <ion-icon name="filter-outline"></ion-icon>
                </div>

                {{-- Search bar --}}
                <div class="search-bar">
                    <input type="text" placeholder="Search rooms..." class="search-input" onkeyup="handleSearchKeyup(event)"
                        autocomplete="off" aria-label="Search rooms">
                </div>
            </div>
        </div>




        <div class="grid-container" id="room-list">
            @foreach ($rooms as $room)
                <div class="room-item" onclick="redirectToRoomInfo({{ $room->id }})"
                    data-floor="{{ $room->floor_number }}" data-type="{{ $room->type }}"
                    data-capacity="{{ $room->member_number }}">
                    <img src="/img/room.png">
                    <div class="form-group">
                        <div class="roomname">{{ $room->name }}</div>
                        <div id="room-price">
                            <span class="price">{{ $room->unit_price }}₫</span>
                            <span class="per-month">/month</span>
                        </div>
                        <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>
                        <div class="type-group">
                            <span class="detail-item">2 Bed</span>
                            <span class="detail-item">Modern Furniture</span>
                            <button class="change-button"
                                onclick="handleRegisterClick(event, {{ $room->id }})">Register</button>
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
            <form action="/register-room" method="POST">
                @csrf
                <input type="hidden" id="room-id-input" name="room_id">

                <div class="form-group">
                    <div>
                        <span class="label-text">Room: </span>

                        <span class="room-detail">{{ $room->name }}</span>
                    </div>
                    <div>
                        <span class="label-text">Price: </span>
                        <span class="room-detail">{{ $room->unit_price }}</span>
                    </div>
                    <div>
                        <span class="label-text">Floor: </span>
                        <span class="room-detail">{{ $room->floor_number }}</span>
                    </div>
                    <div>
                        <span class="label-text">Type: </span>
                        <span class="room-detail room-type">{{ $room->type }}</span>
                    </div>
                    <div>
                        <span class="label-text">Capacity: </span>
                        <span class="room-detail">{{ $room->member_number }}</span>
                    </div>

                    <label>Check-in Date:</label>
                    <input type="date" name="check_in_date" class="form-control" required>

                    <label>Duration (months):</label>
                    <select name="duration" class="form-control" required>
                        <option value="6">6 months</option>
                        <option value="12">12 months</option>
                    </select>
                </div>

                <div class="button-group mt-4">
                    <button type="button" class="btn btn-secondary" onclick="closePopup()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{ asset('./javascript/register.js') }}"></script>
