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
    <link rel="stylesheet" href="{{ asset('./css/payment.css') }}" type="text/css">
    <script src="{{ asset('./payment.js') }}"></script>
</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="container mt-5">
        <h1>Invoices</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Pay Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Note</th>
                    <th scope="col">Task</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td scope="row">{{ $invoice->id }}</td>
                        <td>{{ $invoice->type }}</td>
                        <td>{{ $invoice->total }}</td>
                        <td>{{ $invoice->due_date }}</td>
                        <td>{{ $invoice->paid_date }}</td>
                        <td>{{ $invoice->status }}</td>
                        <td>{{ $invoice->note }}</td>
                        <td><a href="{{ route('student_payment.detail_payment', $invoice->id) }}" class="btn-task">Check</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $invoices->links() }}
    </div>
@endsection
