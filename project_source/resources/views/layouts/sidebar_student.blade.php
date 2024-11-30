<head>
    <link rel="stylesheet" href="{{ asset('./css/sidebar.css') }}" type="text/css">
</head>

@if (auth()->check() && auth()->user()->role === 'student')

<div id="sidebar" class="sidebar">

{{--    Sidebar cho Student--}}

    <div class="logo">
        <span class="icon">📦</span>
        <span class="text">VIP Dormitory</span>
    </div>
    <input type="text" class="search" placeholder="Search">
    <ul class="menu">
        <li class="menu-item">
            <a href="{{ url('/home') }}">
                <span class="icon">🏠</span>
                <span class="text">Home</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('/dashboard') }}">
                <span class="icon">📊</span>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#">
                <span class="icon">🔔</span>
                <span class="text">Notifications</span>
            </a>
        </li>
        <li class="menu-item has-submenu">
            <a href="#">
                <span class="icon">🛏️</span>
                <span class="text">Room</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ url('/regis-test') }}">Register</a></li>
                <li><a href="#">Change</a></li>
                <li><a href="#">Renew</a></li>
                <li><a href="#">Check-out</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#">
                <span class="icon">💳</span>
                <span class="text">Payment</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#">
                <span class="icon">⚙️</span>
                <span class="text">Account</span>
            </a>
        </li>
    </ul>

</div>
@endif

<script>
    // document.addEventListener("DOMContentLoaded", () => {
    //     document.querySelectorAll(".menu-item.has-submenu").forEach(item => {
    //         item.addEventListener("mouseenter", () => {
    //             const submenu = item.querySelector(".submenu");
    //             if (submenu) submenu.style.display = "block";
    //             const nextItems = item.nextElementSibling;
    //             if (nextItems) nextItems.style.transform = "translateY(100%)";
    //         });
    //         item.addEventListener("mouseleave", () => {
    //             const submenu = item.querySelector(".submenu");
    //             if (submenu) submenu.style.display = "none";
    //             const nextItems = item.nextElementSibling;
    //             if (nextItems) nextItems.style.transform = "translateY(0)";
    //         });
    //     });
    // });


    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".menu-item.has-submenu").forEach(item => {
            item.addEventListener("mouseenter", () => {
                const submenu = item.querySelector(".submenu");
                if (submenu) submenu.style.display = "block";
                let nextItem = item.nextElementSibling;
                while (nextItem) {
                    nextItem.style.transform = "translateY(250%)";
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
