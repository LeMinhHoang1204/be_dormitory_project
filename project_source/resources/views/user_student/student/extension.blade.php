<!-- Modal HTML -->
<div id="noResidenceModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>You do not have a registered room. Please register!</p>
    </div>
</div>

<!-- Modal JavaScript -->
<script>
    {{--document.addEventListener("DOMContentLoaded", function() {--}}
    {{--    console.log("DOM fully loaded and parsed");--}}

    {{--    var modal = document.getElementById("noResidenceModal");--}}
    {{--    var span = document.getElementsByClassName("close")[0];--}}

    {{--    // Show the modal if the user does not have a residence--}}
    {{--    @if(session('no_residence'))--}}
    {{--    console.log("No residence session variable is set");--}}
    {{--    modal.style.display = "block";--}}
    {{--    @endif--}}

    {{--    // Close the modal when the user clicks on <span> (x)--}}
    {{--    span.onclick = function() {--}}
    {{--        console.log("Close button clicked");--}}
    {{--        modal.style.display = "none";--}}
    {{--    }--}}

    {{--    // Close the modal when the user clicks anywhere outside of the modal--}}
    {{--    window.onclick = function(event) {--}}
    {{--        if (event.target == modal) {--}}
    {{--            console.log("Clicked outside the modal");--}}
    {{--            modal.style.display = "none";--}}
    {{--        }--}}
    {{--    }--}}
    {{--});--}}
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
            <p><strong>Room:</strong> {{ isset($residence) ? $residence->room->name : 'Room 101' }}</p>
            <p><strong>Unit Price:</strong> {{ isset($residence) ? number_format($residence->room->unit_price) : '800,000' }} VNĐ</p> <!-- Unit Price -->
            <p><strong>Check-in Date:</strong> {{ isset($residence) ? \Carbon\Carbon::parse($residence->start_date)->format('d-m-Y') : '01-12-2023' }}</p>
            <p><strong>Expiration Date:</strong> {{ isset($residence) ? \Carbon\Carbon::parse($residence->end_date)->format('d-m-Y') : '01-12-2024' }}</p>
        </div>

        <form method="POST" action="{{ route('students.extend.store') }}">
            @csrf
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

            <input type="hidden" name="start_date" value="{{ $residence->start_date }}">
            <input type="hidden" name="receiver_id" value="{{ $residence->room->building->manager_id }}">


            <div class="section">
                <button class="btn-complete">Complete</button>
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
