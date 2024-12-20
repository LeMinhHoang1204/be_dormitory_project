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
                <h2 class="mb-0">Invoice Detail</h2>
            </div>
            <div class="card-body">

                <p>Invoice ID: <strong>{{ $invoice->id }}</strong></p>
                <p>Type: <strong>{{ $invoice->type }}</strong></p>
                <p>Sender ID: <strong>{{ $invoice->sender_id }}</strong></p>
                <p>Receiver Type: <strong>{{ $invoice->object_type }}</strong></p>
                <p>Receiver ID: <strong>{{ $invoice->object_id }}</strong></p>
                <p>Send Date: <strong>{{ $invoice->send_date }}</strong></p>
                <p>Due Date: <strong>{{ $invoice->due_date }}</strong></p>
                <p>Paid Date: <strong>{{ $invoice->paid_date }}</strong></p>
                <p>Payment Method: <strong>{{ $invoice->payment_method }}</strong></p>
                <p class="text-success">Status: <strong>{{$invoice->status}}</strong></p>
                <h3>Details</h3>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $invoice->type }}</td>
                            <td>2</td>
                            <td>{{ $invoice->total }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Product B</td>
                            <td>1</td>
                            <td>$15.00</td>
                        </tr> --}}
                    </tbody>
                </table>
                <h4 class="text-end">Total: <strong>{{ $invoice->total }}</strong></h4>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div class="payment-information">
                    <h3>Payment Information</h3>
                    <p>Payment Method: <strong>{{ $invoice->payment_method }}</strong></p>
                    <p>Bank name: <strong>ViettinBank</strong></p>
                    <p>Account name: <strong>LaravelDormitory</strong></p>
                    <p>Account number: <strong>12317477231</strong></p>
                </div>
                <div class="scan-to-pay text-center">
                    <p>Scan to Pay:</p>
                    <img src="{{ asset('images/qrcode.png') }}" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                </div>
            </div>
            <div class="button-group">
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#reportModal">Report</button>
{{--                <form action="{{ url('/vnpay_payment') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <input type="hidden" name="total" value="{{ $invoice->total }}">--}}
{{--                </form>--}}
                <button class="btn btn-primary" id="confirmButton" data-bs-toggle="modal" data-bs-target="#confirmModal">Confirm</button>
            </div>
        </div>
        <!-- Display the uploaded image -->
        @if($invoice->evidence_image)
            <div class="uploaded-image mt-5">
                <h3>Uploaded Evidence Image</h3>
                <img src="{{ asset('storage/' . $invoice->evidence_image) }}" alt="Uploaded Image" style="max-width: 100%; height: auto;">
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
                <h5 class="modal-title" id="reportModalLabel">Report Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reportInvoice', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="reportDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="reportDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="evidenceUpload" class="form-label">Upload Evidence</label>
                        <input class="form-control" type="file" id="evidenceUpload" accept="image/*" name="image">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="sendReport">Send</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('studentConfirmInvoice', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                        <div class="mb-3">
                            <label for="confirmDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="confirmDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="confirmEvidenceUpload" class="form-label">Upload Evidence</label>
                            <input class="form-control" type="file" id="confirmEvidenceUpload" accept="image/*" name="image" required>
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


<script src="{{ asset('javascript/payment.js') }}"></script>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
