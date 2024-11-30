<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production

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

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
