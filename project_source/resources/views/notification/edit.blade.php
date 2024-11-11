{{-- resources/views/notifications/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('notifications.edit', $notification->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="id" class="block text-gray-700 font-bold mb-2">Notification ID:</label>
                            <input type="number" id="id" name="id" value="{{ $notification->id }}" required readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="sender_id" class="block text-gray-700 font-bold mb-2">Sender ID:</label>
                            <input type="number" id="sender_id" name="sender_id" value="{{ auth()->user()->id }}" required readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="recipients" class="block text-gray-700 font-bold mb-2">Recipients (IDs separated by commas):</label>
                            <input type="number" id="receiver_id" name="receiver_id" value="{{ $notification->receiver_id }}" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="recipients" class="block text-gray-700 font-bold mb-2">Title:</label>
                            <input type="text" id="title" name="title" value="{{ $notification->title }}" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                            <select id="type" name="type" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="individual" {{ $notification->type == 'individual' ? 'selected' : '' }}>Individual</option>
                                <option value="group {{ $notification->type == 'group' ? 'selected' : '' }}">Group</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-gray-700 font-bold mb-2">Content:</label>
                            <textarea id="content" name="content" rows="4"  required
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                {{ old('content', $notification->content) }}
                            </textarea>
                        </div>



                        {{-- @can('create', App\Models\Notification::class)--}}
                        <x-primary-button type="submit">
                            {{ ('Save') }}
                        </x-primary-button>
                        {{-- @endcan--}}

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
