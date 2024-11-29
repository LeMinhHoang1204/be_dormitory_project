<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Building Details') }}
        </h2>
    </x-slot>

    <div class="container">
        <h1 class="text-center my-4">Building Details</h1>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Building ID</th>
                        <td>{{ $building->id }}</td>
                    </tr>
                    <tr>
                        <th>Manager</th>
                        <td>{{ $building->managed->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ ucfirst($building->type) }}</td>
                    </tr>
                    <tr>
                        <th>Floor Numbers</th>
                        <td>{{ $building->floor_numbers }}</td>
                    </tr>
                    <tr>
                        <th>Room Numbers</th>
                        <td>{{ $building->room_numbers }}</td>
                    </tr>
                    <tr>
                        <th>Student Count</th>
                        <td>{{ $building->student_count }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="text-center my-4">Rooms</h2>
        <table class="table table-bordered table-striped mt-4">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Floor Number</th>
                <th>Type</th>
                <th>Unit Price</th>
                <th>Member Count</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->floor_number }}</td>
                    <td>{{ ucfirst($room->type) }}</td>
                    <td>{{ $room->unit_price }}</td>
                    <td>{{ $room->member_count }}</td>
                    <td>{{ ucfirst($room->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No rooms found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
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
</x-app-layout>
