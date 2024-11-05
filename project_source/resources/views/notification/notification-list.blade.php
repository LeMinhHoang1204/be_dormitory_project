<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">{{ __('List of Notifications') }}</h3>
                    @foreach ($notifications as $notification)
                        <div class="border-b border-gray-300 py-4">
                            <h4 class="font-semibold">Notification #{{ $notification->id }}</h4>
                            <p><strong>Sender ID:</strong> {{ $notification->sender_id }}</p>
                            <p><strong>Type:</strong> {{ $notification->type == 1 ? 'Individual' : 'Group' }}</p>
                            <p><strong>Content:</strong> {{ $notification->content }}</p>

                            <h5 class="font-semibold mt-2">Recipients:</h5>
                            <ul class="list-disc pl-5">
                                @foreach ($notification->recipients as $recipient)
                                    <li>
                                        <strong>User ID:</strong> {{ $recipient->user->id ?? 'Unknown' }} -
                                        <strong>Name:</strong> {{ $recipient->user->name ?? 'Unknown' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
