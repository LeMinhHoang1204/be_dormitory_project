@extends('Auth_.index')

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

<head>
    <title>Repair Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    {{--    <link rel="stylesheet" href="{{ asset('./css/student/repair.css') }}" type="text/css">--}}
    {{-- WEBSITE: toastr --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="repair-request">
        <h3 class="heading">Repair Request</h3>

        <div class="current-room-info">
            <h5 class="section-title">Current room information</h5>
            <p><strong>Room:</strong> {{$residence->room->name}}</p>
            <p><strong>Building:</strong> {{$residence->room->building->build_name}}</p>
            <p><strong>Manager:</strong> {{$residence->room->building->managedBy->user->name ?? ''}}</p>
        </div>

        <form action="{{ route('students.repair-request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="section1">
                <h5 class="section-title">Select damaged item:</h5>
                <select name="damaged_item" id="damaged_item" class="form-control" required>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->name }}">{{ $asset->name }}</option>
                    @endforeach
                    <option value="other">other</option>
                </select>
                <input type="text" name="other_item" id="other_item" class="form-control" placeholder="Please specify" style="display:none; margin-top: 10px;">
            </div>

            <div class="section">
                <h5 class="section-title">Quantity:</h5>
                <input type="number" name="quantity" id="quantity" class="form-control" required> <!-- Thông tin mô tả giả -->

            </div>

            <div class="section">
                <h5 class="section-title">Describe:</h5>
                <textarea name="description" id="description" class="form-control" placeholder="Fill in here" required></textarea> <!-- Thông tin mô tả giả -->
            </div>

            <div class="section">
                <label for="confirmEvidenceUpload" class="section-title">Upload Evidence</label>
                <input type="file" id="confirmEvidenceUpload" accept="image/*" name="image">
            </div>

            <div class="section">
                <h5 class="section-title">Select repair time:</h5>
                <input type="datetime-local" name="repair_time" id="repair_time" class="form-control" value="2024-12-10"> <!-- Thời gian sửa chữa giả -->
            </div>

            <div class="section">
                <button type="submit" class="btn-complete">Send</button>
                <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>
            </div>
        </form>
    </div>



    <script>
        document.getElementById('damaged_item').addEventListener('change', function() {
            var otherItemInput = document.getElementById('other_item');
            if (this.value === 'other') {
                otherItemInput.style.display = 'block';
            } else {
                otherItemInput.style.display = 'none';
            }
        });
    </script>
@endsection
