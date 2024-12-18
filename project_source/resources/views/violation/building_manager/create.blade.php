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
        <div class="bluefont"><h3>Create Violation</h3></div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.violations.store') }}" method="POST">
            @csrf
            <div class="form-container">

            <div class="form-group">
                <label for="receiver_id">Student *</label>
                <select name="receiver_id" id="receiver_id" class="form-control select2" required>
                    <option value="">Select a student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" data-name="{{ $student->name }}">
                            {{ $student->id }} - {{ $student->name }}
                        </option>
                    @endforeach
                </select>
                <span id="no-student-found" class="text-danger" style="display:none;">No student found</span>
                @error('receiver_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="Violation">Violation</option>
                        <option value="Warning">Warning</option>
                    </select>
                    @error('type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="occurred_at">Occurred At *</label>
                                <input type="datetime-local" name="occurred_at" id="occurred_at" class="form-control" required>
                                @error('occurred_at')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>




            <div class="form-group">
                                <label for="minus_point">Minus Point *</label>
                                <input type="number" name="minus_point" id="minus_point" class="form-control" min="1" max="5" required>
                                @error('minus_point')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
                                @error('note')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <p class="form-control-static">Approved</p>
                <input type="hidden" name="status" id="status" value="Approved">
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="action-buttons" >

            <a href="javascript:void(0);" class="grey-btn" onclick="goBack()"> < Back</a>

            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
            <button type="submit" class="blue-btn">Create</button>
            </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#receiver_id').select2({
                placeholder: 'Search by user_id/ name ',
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
    <style>

        .form-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            /*gap: 15px;*/
        }

        .form-group {
            /*flex: 0 0 48%;*/
            margin-bottom: 15px;

            flex: 0 0 30%; /* Chiều rộng tối đa 45% cho mỗi cột */
            /*display: flex;*/
            flex-direction: row;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group label {
            display: inline-block;
            font-weight: 600;
            /*color: #555;*/
            margin-bottom: 8px;
            color: #0E3B9C;
            font-family: Poppins;
        }
        .form-group option{
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: border 0.3s ease;
        }
        .form-group select{
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: border 0.3s ease;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: border 0.3s ease;
        }

        .form-group textarea {
            resize: none;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #4a90e2;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .form-actions .grey-btn,
        .form-actions .blue-btn {
            margin-left: 10px;
        }
    </style>
@endsection
