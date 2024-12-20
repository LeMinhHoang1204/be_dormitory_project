@extends('Auth_.index')

@section('content')
    @include('layouts.sidebar_student')

    <div class="container">
        <h2>Complaints List</h2>

        @if($complaints->isEmpty())
            <p>No complaints found.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Violation</th>
                    <th>Student</th>
                    <th>Creator</th>
                    <th>Create at</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>#{{ $complaint->violation->id }} - {{ $complaint->violation->title }}</td>
                        <td>{{ $complaint->student->name }}</td>
                        <td>{{ $complaint->creator->name }}</td>
                        <td>{{ $complaint->created_at }}</td>

                        {{--                        <td>{{ $complaint->complaint_description }}</td>--}}
                        <td>{{ $complaint->status }}</td>
                        <td>
                            <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-info">View</a>
                            <!-- Thêm các hành động khác như chỉnh sửa, xóa nếu cần -->
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
