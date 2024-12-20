@extends('Auth_.index')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/detail_payment.css') }}" type="text/css">
</head>

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Request Detail</h2>
            </div>
            <div class="card-body">
                <h3>Request Information</h3>
                <p>Request ID: <strong>{{ $request->id }}</strong></p>
                <p>Sender ID: <strong>{{ $request->sender_id }}</strong></p>
                <p>Receiver ID: <strong>{{$request->receiver_id }} </strong></p>
                <p>Forwarder ID: <strong>{{$request->forwarder_id }} </strong></p>
                <p>Type: <strong>{{$request->type }} </strong></p>
                <p>Status: <strong>{{$request->status }} </strong></p>
                <p>Send date: <strong>{{$request->created_at }} </strong></p>
                <p>Resolve date: <strong>{{$request->resolve_date }} </strong></p>
                <p>Note: <strong>{{$request->note }} </strong></p>

                <h3>Student Information</h3>
                <p>Student ID: <strong>{{$request->sender->id}}</strong></p>
                <p>Full Name: <strong>{{$request->sender->name}}</strong></p>
                <p>Email: <strong>{{$request->sender->email}}</strong></p>
                <p>Phone: <strong>{{$request->sender->phone}}</strong></p>
                <p>Gender: <strong>{{$request->sender->student->gender}}</strong></p>
                <p>Training point: <strong>{{$request->sender->student->training_point}}</strong></p>

                <h3>Current Residence Information</h3>
                <p>Residence ID: <strong>{{$request->sender->residence()->latest()->first()->id}}</strong></p>
                <p>Start Date: <strong>{{$request->sender->residence()->latest()->first()->start_date}}</strong></p>
                <p>End Date: <strong>{{$request->sender->residence()->latest()->first()->end_date}}</strong></p>
                <p>Check out Date: <strong>{{$request->sender->residence()->latest()->first()->check_out_date}}</strong></p>

                <h3>Room Information</h3>
                <p>Building ID: <strong>{{$request->sender->residence()->latest()->first()->room->building_id}}</strong></p>
                <p>Building Type: <strong>{{$request->sender->residence()->latest()->first()->room->building->type}}</strong></p>
                <p>Room ID: <strong>{{$request->sender->residence()->latest()->first()->room_id}}</strong></p>
                <p>Room Name: <strong>{{$request->sender->residence()->latest()->first()->room->name}}</strong></p>
                <p>Room Type: <strong>{{$request->sender->residence()->latest()->first()->room->type}} members</strong></p>
                <p>Current Member Count: <strong>{{$request->sender->residence()->latest()->first()->room->member_count}} members</strong></p>

            </div>

            @if($request->status == 'Pending')
                <div class="card-footer">
                    <div class="button-group">
                        <button class="btn btn-secondary" id="reportButton" data-bs-toggle="modal" data-bs-target="#reportModal">Reject</button>
                        <button class="btn btn-primary" id="confirmButton" data-bs-toggle="modal" data-bs-target="#confirmModal">Accept</button>
                    </div>
                </div>
            @endif
        </div>
        <!-- Display the uploaded image -->
        @if($request->evidence_image)
            <div class="uploaded-image mt-5">
                <h3>Uploaded Evidence Image</h3>
                <img src="{{ asset('storage/' . $request->evidence_image) }}" alt="Uploaded Image" style="max-width: 100%; height: auto;">
            </div>
        @endif
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
                <h5 class="modal-title" id="reportModalLabel">Reject Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('requests.reject', $request->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="reportDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="reportDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="evidenceUpload" class="form-label">Upload Evidence</label>
                        <input class="form-control" type="file" id="evidenceUpload" accept="image/*" name="image">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="sendReport">Send</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Accept Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('requests.accept', $request->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="confirmDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="confirmDescription" name="description" rows="3" readonly >Accepted {{$request->note}} ! Please pay within 7 days of receiving new renewal invoice.</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="confirmEvidenceUpload" class="form-label">Upload Evidence</label>
                        <input class="form-control" type="file" id="confirmEvidenceUpload" accept="image/*" name="image">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="sendConfirm">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sendReport').click(function() {
            $('#successNotification').fadeIn().delay(1000).fadeOut();

            // An modal
            $('#reportModal').modal('hide');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#sendConfirm').click(function() {
            $('#successNotification').fadeIn().delay(1000).fadeOut();

            // Hide modal
            $('#confirmModal').modal('hide');
        });
    });
</script>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
