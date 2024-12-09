@extends('Auth_.index')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>
    <link rel="stylesheet" href="{{ asset('./css/payment.css') }}" type="text/css">
    <script src="{{ asset('./js/payment.js') }}"></script>
</head>

@section('content')
    @include('layouts.sidebar_student')
    
@endsection