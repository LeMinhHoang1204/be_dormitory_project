{{--@extends('Auth_.index')--}}

{{--<head>--}}
{{--    <title>Room Extension</title>--}}
{{--    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">--}}
{{--</head>--}}

{{--@section('content')--}}
{{--    @include('layouts.sidebar_student')--}}

{{--    <div class="extension">--}}
{{--        <h3 class="heading">Room Extension</h3>--}}

{{--        @if (isset($studentRoom))--}}
{{--            <!-- Hiển thị thông tin phòng -->--}}
{{--            <div class="current-room-info">--}}
{{--                <h5 class="section-title">Current room information</h5>--}}
{{--                <p><strong>Room:</strong> {{ $studentRoom->room_name }}</p>--}}
{{--                <p><strong>Price:</strong> {{ number_format($studentRoom->unit_price, 0, ',', '.') }}đ</p>--}}
{{--                <p><strong>Contract Expiry Date:</strong> {{ \Carbon\Carbon::parse($studentRoom->end_date)->format('d/m/Y') }}</p>--}}
{{--            </div>--}}

{{--            <!-- Form gia hạn -->--}}
{{--            <div class="section">--}}
{{--                <h5 class="section-title">Extend</h5>--}}
{{--                <label for="renewal-period">Select renewal period:</label>--}}
{{--                <select name="renewal-period" id="renewal-period" class="form-control">--}}
{{--                    <option value="3">3 months</option>--}}
{{--                    <option value="6">6 months</option>--}}
{{--                    <option value="9">9 months</option>--}}
{{--                    <option value="12">12 months</option>--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            <div class="section">--}}
{{--                <h5 class="section-title">Describe</h5>--}}
{{--                <textarea name="description" id="description" class="form-control" placeholder="Fill in here"></textarea>--}}
{{--            </div>--}}

{{--            <div class="section">--}}
{{--                <button class="btn-complete">Complete</button>--}}
{{--                <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>--}}
{{--            </div>--}}
{{--        @else--}}
{{--            <!-- Thông báo nếu không có phòng -->--}}
{{--            <div class="message-alert">--}}
{{--                {{ $message }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endsection--}}



@extends('Auth_.index')

<head>
    <title>Room Extension</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">

        <h3 class="heading">Room Extension</h3>

        <div class="current-room-info">
            <h5 class="section-title">Current room information</h5>
            <p><strong>Room:</strong> {{ $residence->room->name ?? 'N/A'}}</p>
            <p><strong>Price:</strong> 1200000đ</p>
            <p><strong>Contract Expiry Date:</strong> 31/12/2024</p>
        </div>

        <div class="section">
            <h5 class="section-title">Extend</h5>
            <label for="renewal-period" >Select renewal period:</label>
            <select name="renewal-period" id="renewal-period" class="form-control">
                <option value="3">3 months</option>
                <option value="6">6 months</option>
                <option value="9">9 months</option>
                <option value="12">12 months</option>
            </select>
        </div>

        <div class="section">
            <h5 class="section-title">Describe</h5>
            <textarea name="description" id="description" class="form-control" placeholder="Fill in here"></textarea>
        </div>

        <div class="section">
            <button class="btn-complete">Complete</button>
            <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>
        </div>

        @if(isset($message))
            <div class="message-alert">
                {{ $message }}
            </div>
        @endif
    </div>
@endsection
