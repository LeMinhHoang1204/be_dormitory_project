@extends('Auth_.index')

<head>
    <title>Notification</title>
    <link rel="icon" href="{{ asset('./img/img.png') }}" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/Notification/notification.css') }}" type="text/css">
    <script src="{{ asset('./javascript/notification/notification.js') }}"></script>

    {{-- WEBSITE: tabler icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('a42fc293e9345264b282', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('be-dormitory-channel');

        channel.bind('user-login', function(data) {
            toastr.success(JSON.stringify(data.email) + ' has joined our website');
        });
    </script>

</head>

@section('content')
    @include('layouts.sidebar_student')

    <div class="container">
        <div class="header-container">
            <h1 class="title">Notification</h1>
            <div class="header-controls">
                {{-- Button filter --}}
                <button onclick="togglePanel()" class="filter-icon">
                    <i class="ti ti-adjustments-horizontal"></i>
                </button>

                {{-- Search bar --}}
                <div class="search-bar">
                    <input type="text" placeholder="Search notifications..." class="search-input"
                        onkeyup="handleSearchKeyup(event)" autocomplete="off" aria-label="Search notifications">
                </div>
            </div>
        </div>
    </div>

    <div class="extension">
        <div class="create-button-container">
            @if (auth()->check() &&
                    (auth()->user()->role === 'admin' ||
                        auth()->user()->role === 'building manager' ||
                        auth()->user()->role === 'accountant'))
                <a href="{{ route('notifications.create') }}" class="btn-create">
                    <i class="fas fa-plus"></i>
                    <span>Create Notification</span>
                </a>
            @endif
        </div>

        <!-- Notification list -->
        <div class="notifications-container">
            @forelse ($notifications as $notification)
                <div class="notification-item">
                    <h4 class="notification-title">
                        {{ $notification->title ?? 'Notification' }}
                    </h4>
                    <p class="notification-meta">
                        <i class="fas fa-user"></i>
                        {{ $notification->sender->name ?? 'Admin' }}
                        <span class="text-gray-400">•</span>
                        <i class="far fa-clock"></i>
                        {{ $notification->created_at->format('d/m/Y H:i') }}
                    </p>
                    <p class="notification-content">{{ $notification->content }}</p>

                    <div class="btn-group-action">
                        <button type="button" class="btn-view"
                            onclick="showNotificationModal({{ $notification->id }}, '{{ $notification->title }}', '{{ $notification->content }}', '{{ $notification->sender->name }}', '{{ $notification->created_at->format('d/m/Y H:i') }}')">
                            <i class="far fa-eye"></i> View
                        </button>

                        @can('update', $notification)
                            <a href="{{ route('notifications.show', $notification->id) }}" class="btn-edit">
                                <i class="far fa-edit"></i> Edit
                            </a>
                            <a href="#" onclick="deleteNotification({{ $notification->id }})" class="btn-delete">
                                <i class="far fa-trash-alt"></i> Delete
                            </a>
                            <form id="delete-form-{{ $notification->id }}"
                                action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-4"></i>
                    <p>No notifications found</p>
                </div>
            @endforelse
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $notifications->links() }}
    </div>

    <!-- Notification Details -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                </div>
                <div class="modal-body">
                    <div class="notification-meta">
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <span id="modalSender"></span>
                        </div>
                        <span class="text-gray-400">•</span>
                        <div class="meta-item">
                            <i class="far fa-clock"></i>
                            <span id="modalDate"></span>
                        </div>
                    </div>
                    <p id="modalContent"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Panel filter -->
<form method="GET" action="{{ route('notifications.index') }}">
    <div id="filterPanel" class="filter-panel" onclick="closePanel(event)">
        <div class="filter-panel-content" onclick="event.stopPropagation()">
            <h3 class="filter-title">Filter Notifications</h3>

            <!-- Lọc theo ngày tạo -->
            <div class="filter-section">
                <label class="filter-lable">Sort by Creation Date</label>
                <select name="sort_date" class="filter-input">
                    <option value="recent">Most Recent</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>

            <!-- Lọc theo một ngày cụ thể -->
            <div class="filter-section">
                <label class="filter-label">Specific Date</label>
                <input type="date" name="specific_date" class="filter-input">
            </div>

            <!-- Lọc theo khoảng thời gian -->
            <div class="filter-date-range">
                <div class="date-box">
                    <label class="filter-label">Start Date</label>
                    <input type="date" name="start_date" class="filter-date-input">
                </div>
                <div class="date-box">
                    <label class="filter-label">End Date</label>
                    <input type="date" name="end_date" class="filter-date-input">
                </div>
            </div>

            <!-- Lọc theo người đăng thông báo -->
            <div class="filter-section">
                <label class="filter-label">Posted By</label>
                <div class="filter-checkbox-group">
                    <label><input type="checkbox" name="posted_by" value="building-manager" class="filter-checkbox">
                        Building Manager</label>
                    <label><input type="checkbox" name="posted_by" value="admin" class="filter-checkbox">
                        Admin</label>
                </div>
            </div>

            <!-- Nút Apply -->
            <div class="text-right">
                <button class="btn-apply" type="submit" onclick="applyFilters()">Apply</button>
            </div>
        </div>
    </div>
</form>


<script src="{{ asset('./javascript/notification/notification.js') }}"></script>
