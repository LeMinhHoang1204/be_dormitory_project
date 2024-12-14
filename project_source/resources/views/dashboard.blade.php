<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script type="module" src="{{ Vite::useBuildDirectory('build')->asset('resources/js/app.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        Echo.private('privateNotification.' + {{ Auth::user()->id }})
            .listen('.notificationPrivateHit', (data) => {
                console.log(data);
                toastr.success(JSON.stringify(data.sender) + ' send you a new notification');
            });
    });
</script>

{{--<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}
{{--<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>--}}

{{--<script>--}}
{{--    Pusher.logToConsole = true;--}}

{{--    document.addEventListener("DOMContentLoaded", function() {--}}
{{--        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');--}}


{{--        var pusher = new Pusher('a42fc293e9345264b282', {--}}
{{--        cluster: 'ap1',--}}
{{--        authEndpoint: '/broadcasting/auth', // Ensure you have this endpoint set up for private channels--}}
{{--        auth: {--}}
{{--            headers: {--}}
{{--                'X-CSRF-Token': csrfToken--}}

{{--                }--}}
{{--            }--}}
{{--        });--}}

{{--        // var channel = pusher.subscribe('be-dormitory-channel2');--}}
{{--        var privateC = pusher.subscribe('privateNotification.' + {{ Auth::user()->id }});--}}

{{--        privateC.bind('.notificationPrivate', function(data) {--}}
{{--            console.log(data);--}}
{{--            toastr.success(JSON.stringify(data.sender) + ' send you a new notification');--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}


@extends('Auth_.index')

<head>
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f9fafc;
            font-family: "Poppins", sans-serif;
            color: #3c3c3c;
        }

        .toast-success {
            color: #ffffff !important; /* Màu chữ cho thông báo thành công */
            background-color: #28a745 !important; /* Màu nền */
            font-family: "Poppins", sans-serif !important; /* Font chữ */
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

</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="dashboard-container">
        <h3>{{ __('Welcome back, ') . Auth::user()->name . '!' }}</h3>
        <p>{{ __("You're logged in!") }}</p>
{{--        <a href="#" class="btn-primary">{{ __('Go to Activities') }}</a>--}}
    </div>
@endsection

