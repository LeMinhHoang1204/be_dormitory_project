<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Modal HTML -->
<div id="noResidenceModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>You do not have a registered room. Please register!</p>
    </div>
</div>

<!-- Modal JavaScript -->
<script>

    document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById("noResidenceModal");
        var span = document.getElementsByClassName("close")[0];

        @if(session('no_residence'))
            modal.style.display = "block";
        @endif

        // Close the modal when the user clicks on <span> (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks anywhere outside of the modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });

</script>

@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const error = @json(session('error'));
            // Display the notification
            console.log(error.message);
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

@extends('Auth_.index')

<head>
    <title>Room Extension</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    {{-- WEBSITE: toastr --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="extension">

        <h3 class="heading">Room Extension</h3>

        <div class="current-room-info">
            <h5 class="section-title">Current room information</h5>
            <p><strong>Room:</strong> {{ isset($residence) ? $residence->room->name : 'Room 101' }}</p>
            <p><strong>Unit Price:</strong> {{ isset($residence) ? number_format($residence->room->unit_price) : '800,000' }} VNĐ</p> <!-- Unit Price -->
            <p><strong>Check-in Date:</strong> {{ isset($residence) ? \Carbon\Carbon::parse($residence->start_date)->format('d-m-Y') : 'N/A' }}</p>
            <p><strong>Expiration Date:</strong> {{ isset($residence) ? \Carbon\Carbon::parse($residence->end_date)->format('d-m-Y') : 'N/A' }}</p>
        </div>

        <form method="POST" action="{{ route('students.extend.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="section">
                <h5 class="section-title">Duration</h5>
                <label for="renewal-period" >Select renewal period:</label>
                <select name="renewal_period" id="renewal-period" class="form-control" required>
                    <option disabled selected>Select months</option>
                    <option value="3">3 months</option>
                    <option value="6">6 months</option>
                    <option value="9">9 months</option>
                    <option value="12">12 months</option>
                </select>
            </div>

            <div class="section">
                <h5 class="section-title">Description</h5>
                <textarea name="description" id="description" class="form-control" placeholder="Fill in here" required></textarea>
            </div>

            <div class="section">
                <label for="confirmEvidenceUpload" class="form-label">Upload Evidence</label>
                <input class="form-control" type="file" id="confirmEvidenceUpload" accept="image/*" name="image">
            </div>

            <input type="hidden" name="receiver_id" value="{{ $residence->room->building->managedBy->user_id ?? 1 }}">
            <input type="hidden" name="residence_id" value="{{ $residence->id }}">
            <div class="section">
                <button class="btn-complete">Send</button>
                <button class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>
            </div>
        </form>

        @if(isset($message))
            <div class="message-alert">
                {{ $message }}
            </div>
        @endif
    </div>
@endsection
