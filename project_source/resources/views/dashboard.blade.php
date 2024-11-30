{{--<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}

{{--<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>--}}
{{--<script>--}}

{{--    // Enable pusher logging - don't include this in production--}}

{{--    Pusher.logToConsole = true;--}}

{{--    var pusher = new Pusher('a42fc293e9345264b282', {--}}
{{--        cluster: 'ap1'--}}
{{--    });--}}

{{--    var channel = pusher.subscribe('be-dormitory-channel');--}}

{{--    channel.bind('user-login', function(data) {--}}
{{--        toastr.success(JSON.stringify(data.email) + ' has joined our website');--}}
{{--    });--}}
{{--</script>--}}

{{--<x-app-layout>--}}

{{--    @include('layouts.sidebar_student')--}}

{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900">--}}
{{--                    {{ __("You're logged in!") }}--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-app-layout>--}}


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<title>Dashboard</title>
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

<x-app-layout>
    @include('layouts.sidebar_student')

{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-3xl text-blue-800 leading-tight text-center">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div class="py-12 bg-light min-h-screen">
        <div class="container-fluid layout">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dashboard-panel shadow rounded">
                    <div class="dashboard-content p-6 text-center">
                        <h3 class="text-xl font-bold text-primary mb-4">
                            {{ __('Welcome back, ') . Auth::user()->name . '!' }}
                        </h3>

                        <p class="text-gray-700 text-lg mb-6">
                            {{ __("You're logged in!") }}
                        </p>
                        <button class="btn-primary transition-all">
                            {{ __('Go to Activities') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        /* Global Styles */
        body {
            background-color: #f9fafc;
            font-family: "Poppins", sans-serif;
            color: #3c3c3c;
        }

        /* Dashboard Container */
        .container-fluid.layout {
            background-color: #ffffff;
            padding: 20px 0;
        }

        .dashboard-panel {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .dashboard-content {
            padding: 30px;
        }

        .dashboard-content h3 {
            color: #1d4ed8; /* Primary Color */
            font-family: "Inter", sans-serif;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .dashboard-content p {
            color: #64748b;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Buttons */
        .btn-primary {
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }

        /* Utilities */
        .shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .text-primary {
            color: #1d4ed8;
        }

        .text-gray-700 {
            color: #374151;
        }

        .bg-light {
            background-color: #f9fafc;
        }

    </style>
</x-app-layout>
