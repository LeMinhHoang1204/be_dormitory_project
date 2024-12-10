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
                    <input type="text" placeholder="Search rooms..." class="search-input" onkeyup="handleSearch(event)">
                </div>
            </div>
        </div>




        <div class="grid-container" id="room-list">
            @foreach ($rooms as $room)
                <div class="room-item" onclick="redirectToRoomInfo({{ $room->id }})">
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
                            <button class="change-button" onclick="toggleConfirm()">Register</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $rooms->links() }}
    </div>
@endsection

<!-- Filter Popup -->
<div id="filter-popup" class="filter-popup">
    <div class="popup-content">
        <span class="close" onclick="toggleFilterPopup()">&times;</span>
        <h2>Filter Options</h2>
        <!-- Thêm các tùy chọn lọc ở đây -->
        <div class="filter-options">
            <div class="filter-group">
                <label>Price Range</label>
                <div class="price-inputs">
                    <input type="number" placeholder="Min">
                    <input type="number" placeholder="Max">
                </div>
            </div>
            <!-- Thêm các tùy chọn lọc khác -->
        </div>
    </div>
</div>




<script src="{{ asset('./javascript/register.js') }}"></script>
