<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Update Building') }}
        </h2>
    </x-slot>

    <div class="container">
        <h1 class="text-center my-4">Update Building</h1>

        <x-primary-button>
            <a href="{{ route('rooms.create2', ['building' => $building->id]) }}" style="color: white; text-decoration: none;">
                {{ __('Add room') }}
            </a>
        </x-primary-button>


        <form action="{{ route('buildings.update', $building->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="manager_id" class="block text-gray-700 font-bold mb-2">Manager:</label>
                <select id="manager_id" name="manager_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @if($building->manager_id)
                        <option value="{{$building->managed->id}}" selected>{{$building->managed->user->name}}</option>
                    @else
                        <option value="">-- Select Manager --</option>
                    @endif


                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->user->name }}</option>
                    @endforeach

                    @if($building->manager_id)
                        <option value="">Delete current manager</option>
                    @endif
                </select>
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                <div class="flex items-center">
                    <input type="radio" id="type_male" name="type" value="male" {{ $building->type == 'male' ? 'checked' : '' }} required
                           class="mr-2 leading-tight">
                    <label for="type_male" class="mr-4">Male</label>
                    <input type="radio" id="type_female" name="type" value="female" {{ $building->type == 'female' ? 'checked' : '' }} required
                           class="mr-2 leading-tight ml-4">
                    <label for="type_female">Female</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="floor_numbers" class="block text-gray-700 font-bold mb-2">Floor Numbers:</label>
                <input type="number" id="floor_numbers" name="floor_numbers" required value="{{$building->floor_numbers}}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="room_numbers" class="block text-gray-700 font-bold mb-2">Room Numbers:</label>
                <input type="number" id="room_numbers" name="room_numbers" required value="{{$building->room_numbers}}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <x-primary-button class="ms-4" type="submit">
                {{ __('Update Building') }}
            </x-primary-button>
        </form>
    </div>

    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .text-center {
            text-align: center;
        }

        .my-4 {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .border {
            border: 1px solid #ccc;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .w-full {
            width: 100%;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .leading-tight {
            line-height: 1.25;
        }

        .focus\:outline-none {
            outline: 0;
        }

        .focus\:shadow-outline {
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .font-bold {
            font-weight: 700;
        }
    </style>
</x-app-layout>
