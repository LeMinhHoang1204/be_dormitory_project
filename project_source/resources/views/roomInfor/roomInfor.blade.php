@extends('Auth_.index')

<head>
    <title>Room Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('./css/roomInfor.css') }}" type="text/css">
    <script src="{{ asset('./roomInfor.js') }}"></script>
    <script src="{{ asset('./javascript/reg_room.js') }}"></script>
</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="roominfor-container">
        <main class="roominfor-main">
            <section class="room-info">
                <div class="room-header">
                    <h1>Room Information</h1>
                </div>

                <div class="room-details card">
                    <div class="room-details-container">
                        <div class="room-image-section">
                            <div class="room-image-main">
                                <img src="{{ asset('images/room1.jpg') }}" alt="Room Main Image">
                            </div>
                        </div>
                        <div class="room-info-section">
                            <div class="room-meta">
                                <h2 class="card-title">{{ $room->name }}</h2>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <i class="fas fa-hashtag"></i>
                                        <div class="info-content">
                                            <label>Room ID</label>
                                            <span>{{ $room->id }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-building"></i>
                                        <div class="info-content">
                                            <label>Floor</label>
                                            <span>{{ $room->floor_number }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <div class="info-content">
                                            <label>Price</label>
                                            <span>{{ number_format($room->unit_price) }} ₫/month</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-door-open"></i>
                                        <div class="info-content">
                                            <label>Type</label>
                                            <span>{{ $room->type }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-users"></i>
                                        <div class="info-content">
                                            <label>Member</label>
                                            <span>{{ $room->member_count }} count</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Register Button -->
                                <div class="mt-4">





                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="room-description card mt-4">
                    <div class="card-body">
                        <h3><i class="fas fa-info-circle"></i> Overview</h3>
                        <p>{{ $room->description ?? 'Imagine a cozy dorm room with a modern and inviting atmosphere. The room is illuminated with warm lighting that accentuates the clean, minimalist design. Against one wall, there is a comfortable twin-sized bed with soft, neutral-toned bedding and a few decorative pillows for added comfort. Adjacent to the bed, a sturdy desk and ergonomic chair provide an ideal study space, complete with a sleek lamp and ample storage for books and supplies. The opposite wall features a spacious wardrobe and a set of shelves for personal items and decor. A small window allows natural light to filter in, offering a view of the campus greenery outside. The room is neatly organized, with thoughtful touches like a cozy rug and a few potted plants, creating a welcoming and serene environment for studying and relaxation. ' }}
                        </p>
                    </div>
                </div>

                <div class="photos card mt-4">
                    <div class="card-body">
                        <h3><i class="fas fa-images"></i> Photos</h3>
                        <div class="photo-grid">
                            @foreach (range(1, 6) as $index)
                                <div class="photo-item">
                                    <img src="{{ asset('images/room1.jpg') }}" alt="Room Image {{ $index }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="facilities card mt-4">
                    <div class="card-body">
                        <h3><i class="fas fa-concierge-bell"></i> Facilities</h3>
                        <div class="facilities-grid">
                            <div class="facility-item">
                                <i class="fas fa-wifi"></i>
                                <span>Wifi</span>
                            </div>
                            <div class="facility-item">
                                <i class="fas fa-washing-machine"></i>
                                <span>Washing machine</span>
                            </div>
                            <div class="facility-item">
                                <i class="fas fa-hot-tub"></i>
                                <span>Water heater</span>
                            </div>
                            <div class="facility-item">
                                <i class="fas fa-wind"></i>
                                <span>Air conditioning</span>
                            </div>
                            <div class="facility-item">
                                <i class="fas fa-refrigerator"></i>
                                <span>Refrigerator</span>
                            </div>
                            <div class="facility-item">
                                <i class="fas fa-microwave"></i>
                                <span>Microwave</span>
                            </div>
                            <div class="facility-item">
                                <i class="fas fa-parking"></i>
                                <span>Parking space</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
