@extends('Auth_.index')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/detail_payment.css') }}" type="text/css">
    <script src="{{ asset('javascript/payment.js') }}"></script>
</head>

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Residence Detail</h2>
            </div>
            <div class="card-body">
                <h3>Residence Information</h3>
                <p>Residence ID: <strong>{{ $residence->id }}</strong></p>
                <p>Dorm ID: <strong>{{ $residence->student->id }}</strong></p>
                <p>Student Name: <strong>{{$residence->student->name }} </strong></p>
                <p class="text-success">Status: <strong>Paid</strong></p>

                <p>Registration Date: <strong>{{ $residence->created_at }}</strong></p>
                <p>Start Date: <strong>{{ $residence->start_date }}</strong></p>
                <p>End Date: <strong>{{ $residence->end_date }}</strong></p>

                <h3>Room Information</h3>
                <p>Room ID: <strong>{{ $residence->room_id }}</strong></p>
                <p>Room Name: <strong>{{ $residence->room->name }}</strong></p>
                <p>Room Type: <strong>{{ $residence->room->type }} members</strong></p>
                <p>Member Count: <strong>{{ $residence->room->member_count }}</strong></p>
            </div>

            <form action="{{ route('requests.acceptCheckIn', $residence->id) }}" method="POST">
                @csrf
                <textarea id="note" rows="3" name="note"></textarea>
                <div class="button-group">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#reportModal" type="button">Reject</button>
                    <button class="btn btn-primary" id="transferButton" type="button">Transfer</button>
                    <button class="btn btn-primary" id="confirmButton" type="submit">Accept</button>
               </div>
            </form>
        </div>
    </div>

    <div id="successNotification" class="alert alert-success" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1000;">
        Send Successful
    </div>


@endsection

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('requests.rejectCheckIn', $residence->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="reportDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="reportDescription" rows="3" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="checkbox" id="refundAmount" name="IsRefund">
                            <label for="reportDescription" class="form-label">Refund</label>
                        </div>
                        <div class="mb-3">
                            <label for="evidenceUpload" class="form-label">Upload Evidence</label>
                            <input class="form-control" type="file" id="evidenceUpload" accept="image/*" name="image" required>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="sendReport">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        $('#sendReport').click(function() {--}}
{{--            $('#successNotification').fadeIn().delay(1000).fadeOut();--}}

{{--            // An modal--}}
{{--            $('#reportModal').modal('hide');--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('transferButton').addEventListener('click', function() {
        const id = {{ $residence->id }};
        window.location.href = `{{ url('building-manager/check-in-requests/tranfer-room') }}/${id}`;
    });
});
</script>


<script src="{{ asset('javascript/payment.js') }}"></script>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
