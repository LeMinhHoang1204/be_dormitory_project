
<x-app-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('css/Notification/notification.css') }}" type="text/css">
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="notification-frame">
                <!-- Nút mở panel filter -->
                <div class="text-right">
                    <button onclick="togglePanel()" class="text-right" style="background-color: #2F6BFF; color: white; padding: 8px 16px; border-radius: 4px;">Filter Options</button>
                </div>

                <!-- Panel filter -->
                <form method="GET" action="{{ route('notifications.index') }}">
                    <div id="filterPanel" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden" onclick="closePanel(event)">
                        <div class="filter-panel-content" onclick="event.stopPropagation()">
                            <h3 class="filter-title">Filter Notifications</h3>

                            <!-- Lọc theo ngày tạo -->
                            <div class="filter-section">
                                <label class="bfilter-lable">Sort by Creation Date</label>
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
                                    <label><input type="checkbox" name="posted_by" value="building-manager" class="filter-checkbox"> Building Manager</label>
                                    <label><input type="checkbox" name="posted_by" value="admin" class="filter-checkbox"> Admin</label>
                                </div>
                            </div>

                            <!-- Nút Apply -->
                            <div class="text-right">
                                <button type="submit" onclick="applyFilters()" style="background-color: #2F6BFF; color: white; padding: 8px 16px; border-radius: 4px;">Apply</button>
                            </div>
                        </div>
                    </div>
                </form>

    <script>
        function togglePanel() {
            const panel = document.getElementById('filterPanel');
            panel.classList.toggle('hidden');
        }

        function closePanel(event) {
            const panel = document.getElementById('filterPanel');
            if (event.target === panel) {
                panel.classList.add('hidden');
            }
        }

        function applyFilters() {
            // Thực hiện hành động khi nhấn nút Apply (tùy chỉnh theo logic của bạn)
            togglePanel(); // Đóng panel sau khi nhấn Apply
        }
    </script>



    <!-- Notification list -->
                <div class="notifications-container">
                    @foreach ($notifications as $notification)
                        <div class="notification-item">
                            <h4 class="notification-title">
                                {{ $notification->title ?? 'Notification' }}
                            </h4>
                            <p class="notification-meta">
                                By: {{ $notification->sender->name ?? 'Admin' }} - {{ $notification->created_at->format('d/m/Y H:i:s') }}
                            </p>
                            <p class="notification-content">{{ $notification->content }}</p>

                            <!-- Action Buttons -->
                            <div class="btn">
                                <!-- Edit Button -->
                                <span class="btn-edit">
                                    <a href="{{ route('notifications.show', $notification->id) }}" >
                                        Edit
                                    </a>
                                </span>

{{--                                <span>--}}
                                    <!-- Delete Button -->
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            Delete
                                        </button>
                                    </form>
{{--                                </span>--}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
