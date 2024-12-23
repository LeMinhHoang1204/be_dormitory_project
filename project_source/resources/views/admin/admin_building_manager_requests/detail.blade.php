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
                <p>Sender: <strong>{{ $request->sender_id }} - {{$request->sender->name}}</strong></p>
                <p>Receiver: <strong>{{$request->receiver_id }} - {{$request->receiver->name}} </strong></p>
                <p>Forwarder: <strong>{{$request->forwarder_id }} - {{$request->forwarder->name ?? 'N/A'}} </strong></p>
                <p>Type: <strong>{{$request->type }} </strong></p>
                <p>Status: <strong>{{$request->status }} </strong></p>
                <p>Send date: <strong>{{$request->created_at }} </strong></p>
                <p>Resolve date: <strong>{{$request->resolve_date }} </strong></p>
                <p>Note: <strong>{{$request->note }} </strong></p>

                @if($residence)
                    <h3>Student Information</h3>
                    <p>Student ID: <strong>{{$residence->student->id ?? 'N/A'}} </strong></p>
                    <p>Full Name: <strong>{{$residence->student->name}}</strong></p>
                    <p>Email: <strong>{{$residence->student->email}}</strong></p>
                    <p>Phone: <strong>{{$residence->student->phone}}</strong></p>
                    <p>Gender: <strong>{{$residence->student->student->gender}}</strong></p>
                    <p>Training point: <strong>{{$residence->student->student->training_point}}</strong></p>

                    <h3>Current Residence Information</h3>
                    <p>Residence ID: <strong>{{$residence->id}}</strong></p>
                    <p>Start Date: <strong>{{$residence->start_date}}</strong></p>
                    <p>End Date: <strong>{{$residence->end_date}}</strong></p>
                    <p>Check out Date: <strong>{{$residence->check_out_date}}</strong></p>
                    <p>Status: <strong>{{$residence->status}}</strong></p>
                    <p>Note: <strong>{{$residence->note}}</strong></p>

                    <h3>Room Information</h3>
                    <p>Building ID: <strong>{{$residence->room->building_id}}</strong></p>
                    <p>Building Type: <strong>{{$residence->room->building->type}}</strong></p>
                    <p>Room ID: <strong>{{$residence->room_id}}</strong></p>
                    <p>Room Name: <strong>{{$residence->room->name}}</strong></p>
                    <p>Room Type: <strong>{{$residence->room->type}} members</strong></p>
                    <p>Current Member Count: <strong>{{$residence->room->member_count}} members</strong></p>
                @endif
            </div>

            @if($request->status == 'Pending' && Auth::user()->role != 'student')
                <div class="card-footer">
                    <div class="button-group">
                        <button class="btn btn-secondary" id="reportButton" data-bs-toggle="modal" data-bs-target="#reportModal">Reject</button>
                        <button class="btn btn-primary" id="confirmButton" data-bs-toggle="modal" data-bs-target="#confirmModal">Accept</button>
                    </div>
                </div>
            @endif
            @if($request->status == 'Accepted' && ( $request->type == 'Fixing' || $request->type == 'Refund') && Auth::user()->role != 'student')
                <div class="card-footer">
                    <div class="button-group">
                        <button class="btn btn-primary" id="resolveButton" data-bs-toggle="modal" data-bs-target="#resolveModal">Resolve</button>
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
                <form action="{{ Auth::user()->role == 'accountant' ? route('accountantRejectRequest', $request->id) : route('requests.reject', $request->id) }}" method="POST" enctype="multipart/form-data">
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

            <form action="{{ Auth::user()->role == 'accountant' ? route('accountantAcceptRequest', $request->id) : route('requests.accept', $request->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="confirmDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="confirmDescription" name="description" rows="3"></textarea>
                        {{--                        <textarea class="form-control" id="confirmDescription" name="description" rows="3" readonly>Accepted!--}}
    {{--                            {{$request->type == 'Renewal'--}}
    {{--                            ? $request->note. 'Please pay within 7 days of receiving new renewal invoice.'--}}
    {{--                            : '' }}--}}
    {{--                        </textarea>--}}

                    </div>
                    @if($request->type == 'Change Room')
                        <div class="mb-3">
                            <label for="confirmEvidenceUpload" class="form-label">New start date:</label>
                            <input class="form-control" type="datetime-local" name="new_start_date" min="{{$residence->start_date->addMonths(1)}}" required>
                        </div>
                    @endif
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

<!-- Resolve Modal -->
<div class="modal fade" id="resolveModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Resolve Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ Auth::user()->role == 'accountant' ? route('accountantResolveRequest', $request->id) : route('requests.resolve', $request->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="confirmDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="confirmDescription" name="description" rows="3">
                            {{$request->type == 'Renewal' || $request->type== 'Change room'
                            ? $request->note. 'Please pay within 7 days of receiving new renewal invoice.'
                            : '' }}
                        </textarea>
                    </div>
                    @if($request->type == 'Change Room')
                        <div class="mb-3">
                            <input type="checkbox" id="fixingCost" name="IsCost">
                            <label for="reportDescription" class="form-label">Require cost</label>
                        </div>
                    @endif
                    <div class="mb-3" id="fixingCostInput" style="display: none;">
                        <label for="fixingCostValue" class="form-label">Fixing Cost (VND)</label>
                        <input type="number" class="form-control" id="fixingCostValue" name="fixingCost" min="0" step="10000">
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


{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        $('#sendReport').click(function() {--}}
{{--            $('#successNotification').fadeIn().delay(1000).fadeOut();--}}

{{--            // An modal--}}
{{--            $('#reportModal').modal('hide');--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        $('#sendConfirm').click(function() {--}}
{{--            $('#successNotification').fadeIn().delay(1000).fadeOut();--}}

{{--            // Hide modal--}}
{{--            $('#confirmModal').modal('hide');--}}
{{--        });--}}

{{--        $('#fixingCost').change(function() {--}}
{{--            if ($(this).is(':checked')) {--}}
{{--                $('#fixingCostInput').show();--}}
{{--            } else {--}}
{{--                $('#fixingCostInput').hide();--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
