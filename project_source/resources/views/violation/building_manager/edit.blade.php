@extends('Auth_.index')

<head>
    <title>Create Violation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/avatar.css') }}" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="extension">
        <h1>Edit Violation</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('violations.update', $violation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="receiver_id">Student</label>
                <select name="receiver_id" id="receiver_id" class="form-control select2" required>
                    <option value="">Select a student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ $student->id == $violation->receiver_id ? 'selected' : '' }}>
                            {{ $student->id }} - {{ $student->name }}
                        </option>
                    @endforeach
                </select>
                @error('receiver_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="Violation" {{ $violation->type === 'Violation' ? 'selected' : '' }}>Violation</option>
                    <option value="Warning" {{ $violation->type === 'Warning' ? 'selected' : '' }}>Warning</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                       value="{{ old('title', $violation->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $violation->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="occurred_at">Occurred At</label>
                <input type="datetime-local" name="occurred_at" id="occurred_at" class="form-control"
                       value="{{ old('occurred_at', $violation->occurred_at) }}" required>
            </div>

            <div class="form-group">
                <label for="minus_point">Minus Point</label>
                <input type="number" name="minus_point" id="minus_point" class="form-control"
                       value="{{ old('minus_point', $violation->minus_point) }}" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="note">Note</label>
                <textarea name="note" id="note" class="form-control">{{ old('note', $violation->note) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('#receiver_id').select2({
                placeholder: 'Search for a student by user_id or Name ',
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('admin.search_students') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (student) {
                                return {
                                    id: student.id,
                                    text: student.text
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

        });
    </script>
@endsection
