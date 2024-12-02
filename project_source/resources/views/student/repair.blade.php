{{--@extends('Auth_.index')--}}

{{--<head>--}}
{{--    <title>Repair Request</title>--}}
{{--<link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">--}}

{{--    <link rel="stylesheet" href="{{ asset('./css/student/repair.css') }}" type="text/css">--}}
{{--</head>--}}

{{--@section('content')--}}
{{--    @include('layouts.sidebar_student')--}}

{{--    <div class="repair-request">--}}
{{--        <h3 class="heading">Repair Request</h3>--}}

{{--        @if (session('success'))--}}
{{--            <div class="alert alert-success">--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @if (isset($studentRoom))--}}
{{--            <div class="current-room-info">--}}
{{--                <h5 class="section-title">Current room information</h5>--}}
{{--                <p><strong>Room:</strong> {{ $studentRoom->room_name }}</p>--}}
{{--                <p><strong>Price:</strong> {{ number_format($studentRoom->unit_price, 0, ',', '.') }}đ</p>--}}
{{--                <p><strong>Contract Expiry Date:</strong> {{ \Carbon\Carbon::parse($studentRoom->end_date)->format('d/m/Y') }}</p>--}}
{{--            </div>--}}

{{--            <form action="{{ route('repair-request.store') }}" method="POST">--}}
{{--                @csrf--}}
{{--                <div class="section">--}}
{{--                    <h5 class="section-title">Select damaged item:</h5>--}}
{{--                    <select name="damaged_item" id="damaged_item" class="form-control">--}}
{{--                        <option value="Lavabo">Lavabo</option>--}}
{{--                        <option value="Door">Door</option>--}}
{{--                        <option value="Window">Window</option>--}}
{{--                        <option value="Fan">Fan</option>--}}
{{--                        <option value="Light">Light</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="section">--}}
{{--                    <h5 class="section-title">Describe:</h5>--}}
{{--                    <textarea name="description" id="description" class="form-control" placeholder="Fill in here"></textarea>--}}
{{--                </div>--}}

{{--                <div class="section">--}}
{{--                    <h5 class="section-title">Select repair time:</h5>--}}
{{--                    <input type="date" name="repair_time" id="repair_time" class="form-control">--}}
{{--                </div>--}}

{{--                <div class="section">--}}
{{--                    <button type="submit" class="btn-complete">Submit</button>--}}
{{--                    <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        @else--}}
{{--            <div class="message-alert">--}}
{{--                {{ $message }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endsection--}}


@extends('Auth_.index')

<head>
    <title>Repair Request</title>
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    {{--    <link rel="stylesheet" href="{{ asset('./css/student/repair.css') }}" type="text/css">--}}
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="repair-request">
        <h3 class="heading">Repair Request</h3>


        @if (isset($studentRoom) || true) <!-- Để fake dữ liệu -->
        <div class="current-room-info">
            <h5 class="section-title">Current room information</h5>
            <p><strong>Room:</strong>  A101</p>
            <p><strong>Price:</strong> 1200000đ</p>
            <p><strong>Contract Expiry Date:</strong> 31/12/2024</p>
        </div>

        <form action="{{ route('repair-request.store') }}" method="POST">
            @csrf
            <div class="section1">
                <h5 class="section-title">Select damaged item:</h5>
                <select name="damaged_item" id="damaged_item" class="form-control">
                    <option value="Lavabo">Lavabo</option>
                    <option value="Door">Door</option>
                    <option value="Window">Window</option>
                    <option value="Fan">Fan</option>
                    <option value="Light">Light</option>
                </select>
            </div>
            <div class="section">
                <h5 class="section-title">Describe:</h5>
                <textarea name="description" id="description" class="form-control" placeholder="Fill in here"></textarea> <!-- Thông tin mô tả giả -->
            </div>

            <div class="section">
                <h5 class="section-title">Select repair time:</h5>
                <input type="date" name="repair_time" id="repair_time" class="form-control" value="2024-12-10"> <!-- Thời gian sửa chữa giả -->
            </div>

            <div class="section">
                <button type="submit" class="btn-complete">Complete</button>
                <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>
            </div>
        </form>
        @else
            <div class="message-alert">
                No room information available.
            </div>
        @endif
    </div>

    <style>

        .repair-request {
            max-width: 50%;
            margin: 40px auto;
            padding: 30px;
            background-color: #f9f9f9;
            box-shadow: 0px 6px 4px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        .repair-request p {
            align-items: center;
            margin-bottom: 10px; /* Tăng khoảng cách giữa các đoạn văn */
            font-family: Poppins;
            color: #001738;
            line-height: 1.6; /* Thêm khoảng cách giữa các dòng */
        }

        .section1 {
            display: flex;
            align-items: center;  /* Căn giữa dọc */
        }
        #damaged_item {
            width: 200px;
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Đổ bóng cho dropdown */
            font-size: 16px;
            margin-left: 30px;  /* Thêm khoảng cách giữa select và các phần tử khác */

        }
        #repair_time {
            font-size: 16px;
        }
    </style>
@endsection
