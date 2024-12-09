<head>
    <link rel="stylesheet" href="{{ asset('./css/sidebar.css') }}" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>


<div id="sidebar" class="sidebar">
    <div class="logo">
        <span class="icon">🧑‍💻</span>
        <!-- Hiển thị tên role của user -->
        <span class="text">{{ auth()->check() ? ucfirst(auth()->user()->role) : '' }}</span>
    </div>

{{--    <input type="text" class="search" placeholder="Search">--}}
    <ul class="menu">
        <li class="menu-item">
            <a href="{{ url('/home') }}">
                <span class="icon">🏠</span>
                <span class="text">Home</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('/dashboard') }}">
                <span class="icon">🖥️</span>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="notifications">
                <span class="icon">🔔</span>
                <span class="text">Notifications</span>
            </a>
        </li>

{{--        Payment and Request about room for Student--}}
        @if (auth()->check() && auth()->user()->role === 'student')
        <li class="menu-item has-submenu">
            <a href="#">
                <span class="icon">🛏️</span>
                <span class="text">Room</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ url('/regis-test') }}">Register</a></li>
                <li><a href="/student/repair-request">Repair</a></li>
                <li><a href="#">Change</a></li>
                <li><a href="/student/extension">Extension</a></li>
                <li><a href="/student/checkout">Check-out</a></li>
            </ul>
        </li>
            <li class="menu-item">
                <a href="#">
                    <span class="icon">🏃‍♂️</span>
                    <span class="text">Activites</span>
                </a>
            </li>
        <li class="menu-item">
            <a href="{{ url('/payment') }}">
                <span class="icon">💳</span>
                <span class="text">Payment</span>
            </a>
        </li>
        @endif

        @if (auth()->check() && auth()->user()->role === 'admin')
            <li class="menu-item">
                <a href="/buildings">
                    <span class="icon">🏢</span>
                    <span class="text">Building</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="#">
                    <span class="icon">🏃‍♂️</span>
                    <span class="text">Activites</span>
                </a>
            </li>

        @endif
        @if (auth()->check() && auth()->user()->role === 'building manager')
            <li class="menu-item">
                <a href="">
                    <span class="icon">👨‍🎓</span>
                    <span class="text">Check in student</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="">
                    <span class="icon">📑</span>
                    <span class="text">Request</span>
                </a>
            </li>
            <li class="menu-item has-submenu">
                <a href="">
                    <span class="icon">⚠️</span>
                    <span class="text">Violations</span>
                </a>
                <ul class="submenu">
                    <li><a href="#">List of violations</a></li>
                    <li><a href="#">Complaint</a></li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->role === 'accountant')
            <li class="menu-item">
                <a href="">
                    <span class="icon">📋</span>
                    <span class="text">Receipt List</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="">
                    <span class="icon">📈</span>
                    <span class="text">Statistical Report</span>
                </a>
            </li>
        @endif
        <li class="menu-item">
            <a href="#">
                <span class="icon">⚙️</span>
                <span class="text">Account</span>
            </a>
        </li>
    </ul>

</div>


<script>

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".menu-item.has-submenu").forEach(item => {
            item.addEventListener("mouseenter", () => {
                const submenu = item.querySelector(".submenu");
                if (submenu) submenu.style.display = "block";
                let nextItem = item.nextElementSibling;
                while (nextItem) {
                    nextItem.style.transform = "translateY(300%)";
                    nextItem = nextItem.nextElementSibling;
                }
            });
            item.addEventListener("mouseleave", () => {
                const submenu = item.querySelector(".submenu");
                if (submenu) submenu.style.display = "none";
                let nextItem = item.nextElementSibling;
                while (nextItem) {
                    nextItem.style.transform = "translateY(0)";
                    nextItem = nextItem.nextElementSibling;
                }
            });
        });
    });
</script>
