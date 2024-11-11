<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <!-- Nút mở panel filter -->
                <div class="text-right">
                    <button onclick="togglePanel()" class="text-right" style="background-color: #2F6BFF; color: white; padding: 8px 16px; border-radius: 4px;">Filter Options</button>
                </div>

                <!-- Panel filter -->
                <form method="GET" action="{{ route('notifications.index') }}">
                    <div id="filterPanel" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden" onclick="closePanel(event)">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Filter Notifications</h3>

                            <!-- Lọc theo ngày tạo -->
                            <div class="mb-4">
                                <label class="block text-sm text-gray-600">Sort by Creation Date</label>
                                <select name="sort_date" class="border border-gray-300 rounded w-full px-4 py-2">
                                    <option value="recent">Most Recent</option>
                                    <option value="oldest">Oldest</option>
                                </select>
                            </div>

                            <!-- Lọc theo một ngày cụ thể -->
                            <div class="mb-4">
                                <label class="block text-sm text-gray-600">Specific Date</label>
                                <input type="date" name="specific_date" class="border border-gray-300 rounded w-full px-4 py-2">
                            </div>

                            <!-- Lọc theo khoảng thời gian -->
                            <div class="flex space-x-4 mb-4">
                                <div>
                                    <label class="block text-sm text-gray-600">Start Date</label>
                                    <input type="date" name="start_date" class="border border-gray-300 rounded w-full px-4 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600">End Date</label>
                                    <input type="date" name="end_date" class="border border-gray-300 rounded w-full px-4 py-2">
                                </div>
                            </div>

                            <!-- Lọc theo người đăng thông báo -->
                            <div class="mb-4">
                                <label class="block text-sm text-gray-600">Posted By</label>
                                <div class="space-y-2">
                                    <label><input type="checkbox" name="posted_by" value="building-manager" class="mr-2"> Building Manager</label>
                                    <label><input type="checkbox" name="posted_by" value="admin" class="mr-2"> Admin</label>
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
                <div class="space-y-6">
                    @foreach ($notifications as $notification)
                        <div class="border-b border-gray-200 pb-6">
                            <h4 class="text-lg font-semibold text-blue-700 mb-2">
                                {{ $notification->title ?? 'Notification' }}
                            </h4>
                            <p class="text-gray-600 mb-2 text-sm">
                                By: {{ $notification->sender->name ?? 'Admin' }} - {{ $notification->created_at->format('d/m/Y H:i:s') }}
                            </p>
                            <p class="text-gray-800 mb-4">{{ $notification->content }}</p>

                            <!-- Action Buttons -->
                            <div class="flex space-x-4">
                                <!-- Edit Button -->
                                <a href="{{ route('notifications.show', $notification->id) }}"
                                   style="background-color: #2F6BFF; color: white; padding: 8px 16px; border-radius: 4px; margin-right: 10px">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background-color: #FF0000; color: white; padding: 8px 16px; border-radius: 4px;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
