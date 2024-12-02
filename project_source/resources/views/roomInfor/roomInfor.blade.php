@extends('Auth_.index')

<head>
    <title>Room Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/roomInfor.css') }}" type="text/css">
    <script src="{{ asset('./roomInfor.js') }}"></script>
</head>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="style_header">
                    <h2 class="h2_header">Room Information</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="border">
                    <div class="row">
                        <div class="col-12">
                            <div class="style_header">
                                <h3 class="h3_header">Room {{ $room->name }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p>Price: {{ $room->unit_price }}</p>
                            <p>Type: {{ $room->type }}</p>
                            <p>Floor Number: {{ $room->floor_number }}</p>
                            <!-- Thêm các thông tin khác của phòng -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
