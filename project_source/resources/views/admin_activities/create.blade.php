
@extends('Auth_.index')

<head>
    <title>Create Activity</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">

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
            text-align: right;
            margin-top: 20px;
        }

        .form-actions .grey-btn,
        .form-actions .blue-btn {
            margin-left: 10px;
        }
    </style>
</head>

@section('content')
    @include('layouts.sidebar_student')

    @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'building manager']))
        <div class="extension">
            <div class="bluefont"><h3>Create New Activity</h3></div>
            <div class="activity-info">
                <p><strong>Activity ID:</strong> #{{ $activity->id }}</p>
                <p><strong>Create Date:</strong> {{ \Carbon\Carbon::parse($activity->created_at)->format('d M, Y') }}</p>
            </div>
            <form action="{{ route('activities.store') }}" method="POST">
                @csrf
                <div class="form-container">
                    <!-- Left Column -->

                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea id="note" name="note" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="register_end_date">Registration End Date *</label>
                        <input type="date" id="register_end_date" name="register_end_date" required>
                    </div>

                    <!-- Right Column -->
                    <div class="form-group">
                        <label for="start_date">Start Date *</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date *</label>
                        <input type="date" id="end_date" name="end_date" required>
                    </div>

                    <div class="form-group">
                        <label for="max_participants">Max Participants *</label>
                        <input type="number" id="max_participants" name="max_participants" required>
                    </div>

                    <div class="form-group">
                        <label for="ticket_price">Ticket Price (VND) *</label>
                        <input type="number" id="ticket_price" name="ticket_price" required>
                    </div>

                    <div class="form-group">
                        <label for="bonus_point">Bonus Points *</label>
                        <input type="number" id="bonus_point" name="bonus_point" required>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <a href="javascript:void(0);" class="grey-btn" onclick="window.history.back()">Cancel</a>
                    <button class="blue-btn">Create</button>
                </div>
            </form>
        </div>
    @endif
@endsection
