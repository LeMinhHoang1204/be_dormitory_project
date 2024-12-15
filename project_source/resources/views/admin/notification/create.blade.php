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
                    <form action="{{ route('notifications.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="sender_id" class="block text-gray-700 font-bold mb-2">Sender ID:</label>
                            <input type="number" id="sender_id" name="sender_id" value="{{ auth()->user()->id }}" required readonly
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                            <select id="type" name="type" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    onchange="toggleGroupOptions(this.value)">
                                <option value="" disabled selected>Receiver type</option>
                                <option value="individual">Individual</option>
                                <option value="group">Group</option>
                            </select>
                        </div>

                        <div id="group-options" class="mb-4 hidden">
                            <label for="group" class="block text-gray-700 font-bold mb-2">Select Room or Building:</label>
                            <select id="group" name="group"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    onchange="loadBuildings(this.value)">
                                <option value="" disabled selected>Group type</option>
                                <option value="building">Building</option>
                                <option value="room">Room</option>
                            </select>
                        </div>

                        <div id="building-options" class="mb-4 hidden">
                            <label for="building" class="block text-gray-700 font-bold mb-2">Select Building:</label>
                            <select id="building" name="building_object_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>

                        <div id="room-options" class="mb-4 hidden">
                            <label for="room" class="block text-gray-700 font-bold mb-2">Select Room:</label>
                            <select id="room" name="room_object_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>

                    <div id="user-options" class="mb-4 hidden">
                        <label for="user" class="block text-gray-700 font-bold mb-2">Select Receiver:</label>
                        <select id="user" name="user_object_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <optgroup label="Building Manager">
                                <!-- Options for Building Manager will be populated by JavaScript -->
                            </optgroup>
                            <optgroup label="Accountant">
                                <!-- Options for Accountant will be populated by JavaScript -->
                            </optgroup>
                            <optgroup label="Student">
                                <!-- Options for Student will be populated by JavaScript -->
                            </optgroup>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="recipients" class="block text-gray-700 font-bold mb-2">Title:</label>
                        <input type="text" id="title" name="title" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 font-bold mb-2">Content:</label>
                        <textarea id="content" name="content" rows="4" required
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>



{{--                        @can('create', App\Models\Notification::class)--}}
                            <x-primary-button class="ms-4" type="submit">
                                {{ ('Create Notification') }}
                            </x-primary-button>
{{--                        @endcan--}}

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function toggleGroupOptions(value) {
        const groupOptions = document.getElementById('group-options');
        const buildingOptions = document.getElementById('building-options');
        const roomOptions = document.getElementById('room-options');
        const userOptions = document.getElementById('user-options');

        if (value === 'group') {
            groupOptions.classList.remove('hidden');
            buildingOptions.classList.add('hidden');
            roomOptions.classList.add('hidden');
            userOptions.classList.add('hidden');
        }
        else if (value === 'individual') {
            userOptions.classList.remove('hidden');
            groupOptions.classList.add('hidden');
            buildingOptions.classList.add('hidden');
            roomOptions.classList.add('hidden');
        }
        else {
            groupOptions.classList.add('hidden');
            buildingOptions.classList.add('hidden');
            roomOptions.classList.add('hidden');
            userOptions.classList.add('hidden');
        }
    }

    function loadBuildings(value) {
        const buildingOptions = document.getElementById('building-options');
        const roomOptions = document.getElementById('room-options');
        const buildingSelect = document.getElementById('building');
        const roomSelect = document.getElementById('room');

        if (value === 'building') {
            fetch('/admin/getAllBuildings')
                .then(response => response.json())
                .then(data => {
                    buildingSelect.innerHTML = '';
                    data.forEach(building => {
                        const option = document.createElement('option');
                        option.value = building.id;
                        option.textContent = building.build_name;
                        buildingSelect.appendChild(option);
                    });
                    buildingOptions.classList.remove('hidden');
                    roomOptions.classList.add('hidden');
                })
                .catch(error => console.error('Error loading buildings:', error));
        } else if (value === 'room') {
            fetch('/admin/getAllBuildings')
                .then(response => response.json())
                .then(data => {
                    buildingSelect.innerHTML = '';
                    data.forEach(building => {
                        const option = document.createElement('option');
                        option.value = building.id;
                        option.textContent = building.build_name;
                        buildingSelect.appendChild(option);
                    });
                    buildingOptions.classList.remove('hidden');
                    roomOptions.classList.add('hidden');

                    buildingSelect.addEventListener('change', function() {
                        fetch('/admin/getAllRooms/' + buildingSelect.value)
                            .then(response => response.json())
                            .then(data => {
                                roomSelect.innerHTML = '';
                                data.forEach(room => {
                                    const option = document.createElement('option');
                                    option.value = room.id;
                                    option.textContent = room.name;
                                    roomSelect.appendChild(option);
                                });
                                roomOptions.classList.remove('hidden');
                            })
                            .catch(error => console.error('Error loading rooms:', error));
                    });
                })
                .catch(error => console.error('Error loading buildings:', error));
        } else {
            buildingOptions.classList.add('hidden');
            roomOptions.classList.add('hidden');
        }
    }

    function loadUsers() {
    fetch('/admin/getAllUsers')
        .then(response => response.json())
        .then(data => {
            const userSelect = document.getElementById('user');
            const buildingManagerOptions = document.createElement('optgroup');
            buildingManagerOptions.label = 'Building Manager';
            const accountantOptions = document.createElement('optgroup');
            accountantOptions.label = 'Accountant';
            const studentOptions = document.createElement('optgroup');
            studentOptions.label = 'Student';

            userSelect.innerHTML = '';

            data.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                if (user.role === 'building manager') {
                    buildingManagerOptions.appendChild(option);
                } else if (user.role === 'accountant') {
                    accountantOptions.appendChild(option);
                } else if (user.role === 'student') {
                    studentOptions.appendChild(option);
                }
            });

            userSelect.appendChild(buildingManagerOptions);
            userSelect.appendChild(accountantOptions);
            userSelect.appendChild(studentOptions);
        })
        .catch(error => console.error('Error loading users:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});

</script>
