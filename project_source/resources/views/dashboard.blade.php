@extends('Auth_.index')

<head>
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        body {
            background-color: #f9fafc;
            font-family: "Poppins", sans-serif;
            color: #3c3c3c;
        }

        .container-fluid.layout {
            background-color: #fff;
            padding: 10px 0;
        }
        .dashboard-container {
            max-width: 50%;
            margin: 80px auto;
            padding: 30px;
            background-color: #f9f9f9;
            box-shadow: 0px 6px 4px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        .dashboard-container h3 {
            font-family: Inter;
            color: #0e3b9c;
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard-container p {
            color: #001738;
            font-size: 20px;
            text-align: center;
            line-height: 1.6;
            font-family: Poppins;

        }

        .btn-primary {
            background-color: #2F6BFF;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            margin: 20px auto;
            display: block;
            text-align: center;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }
    </style>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('a42fc293e9345264b282', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('be-dormitory-channel');

        channel.bind('user-login', function(data) {
            toastr.success(JSON.stringify(data.email) + ' has joined our website');
        });
    </script>
</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="dashboard-container">
        <h3>{{ __('Welcome back, ') . Auth::user()->name . '!' }}</h3>
        <p>{{ __("You're logged in!") }}</p>
{{--        <a href="#" class="btn-primary">{{ __('Go to Activities') }}</a>--}}
    </div>
@endsection

