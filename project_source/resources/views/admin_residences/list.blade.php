<x-app-layout>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Notification/notification.css') }}" type="text/css">
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Residence Details') }}
        </h2>
    </x-slot>

    <div class="container">
        @can('create', App\Models\Residence::class)
            <x-primary-button>
                <a href="{{ route('residences.create' ,[$building->id, $room->id]) }}" style="color: white; text-decoration: none;">
                    {{ __('Add Residence') }}
                </a>
            </x-primary-button>
        @endcan
        <h2 class="text-center my-4">Residences</h2>
        <table class="table table-bordered table-striped mt-4">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Room</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Last Update</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($residences as $residence)
                <tr>
                    <td>{{ $residence->id }}</td>
                    <td>{{ $residence->student->user->name ?? 'N/A' }}</td>
                    <td>{{ $residence->room_id ?? 'N/A' }}</td>
                    <td>{{ $residence->start_date }}</td>
                    <td>{{ $residence->end_date }}</td>
                    <td>{{ $residence->status }}</td>
                    <td>{{ $residence->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class="btn">
                            <!-- Edit Button -->
                            <span class="btn-edit">
                                <a href="{{ route('residences.edit', [$building->id, $room->id, $residence->id]) }}">
                                    Edit
                                </a>
                            </span>

                            <!-- Delete Button -->
                            @can('delete', $residence)
                                <form action="{{ route('residences.destroy', [$building->id, $room->id, $residence->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this residence?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No residences found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
{{--        {{ $residences->links() }}--}}
    </div>

    <style>
        .container {
            max-width: 1200px;
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

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }

        th, td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        th {
            text-align: inherit;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>

    <script>
        window.addEventListener('beforeunload', function () {
            localStorage.setItem('scrollPosition', window.scrollY);
        });
    </script>

    <script>
        window.addEventListener('load', function () {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition, 10));
                localStorage.removeItem('scrollPosition');
            }
        });
    </script>
</x-app-layout>
