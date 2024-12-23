<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dormitory Management</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<header>
    <img src="{{ asset('images/logo.png') }}" class="logo">
    <nav>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#infor">Infor</a></li>
            <li><a href="#facility">Facilities</a></li>
            <li><a href="#benefit">Benefits</a></li>
            <li><a href="#about">About</a></li>
        </ul>
    </nav>
    <div class="auth-buttons">
        <button id="login" onclick="window.location='{{ route('login') }}'">Login</button>
        <button id="register" onclick="window.location='{{ route('register') }}'">Register</button>
    </div>

</header>

<main>

    @if (session('error'))
        <div class="alert-custom-error">
            <span>{{ session('error') }}</span>
            <!-- Nút đóng thông báo -->
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif

    <!-- home -->
    <section id="home">
        <div id="banner">
            <h1>Dormitory of University of Information Technology</h1>
            <p>Enjoy memorable moments and experience exciting activities in the dormitory</p>
        </div>
        <div class="quick-search">
            <div class="container">
                <div class="item">
                    <i class="fa-solid fa-user"></i>
                    <div class="div-wrapper">
                        <div class="text-wrapper">Number</div>
                    </div>
                </div>
                <div class="container-wrapper">
                    <div class="combobox-menu-wrapper">
                        <div class="combobox-menu">
                            <select class="combobox">
                                <option value="single">2 people</option>
                                <option value="double">4 people</option>
                                <option value="suite">8 people</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-2">
                <div class="item">
                    <i class="fa-solid fa-door-open"></i>
                    <div class="div-wrapper">
                        <div class="text-wrapper">Type room</div>
                    </div>
                </div>
                <div class="container-wrapper">
                    <div class="combobox-menu-wrapper">
                        <div class="combobox-menu">
                            <select class="combobox">
                                <option value="single">Single Room</option>
                                <option value="double">Double Room</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-3">
                <div class="item">
                    <i class="fa-solid fa-building"></i>
                    <div class="div-wrapper">
                        <div class="text-wrapper">Building</div>
                    </div>
                </div>
                <div class="container-wrapper">
                    <div class="combobox-menu-wrapper">
                        <div class="combobox-menu">
                            <select class="combobox">
                                <option value="a">A101</option>
                                <option value="b">A102</option>
                                <option value="c">B101</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-wrapper">
                <button class="button">
                    <i id="icon-search" class="fa-solid fa-magnifying-glass"></i>
                    <div class="text-wrapper-3" onclick="window.location.href='/students/room-registration'">Search</div>
                </button>
            </div>
        </div>
    </section>

    <!-- infor -->
    <section id="infor">
        <div class="infor-container flex-container">
            <div class="banner">
                <h1>Modern dormitory, making student life easier</h1>
                <p>Building a dormitory system to become a training and learning environment. Green living
                    environment, happy living; the ideal living space of students.</p>
            </div>
            <div class="images-container">
                <img src="{{ asset('images/isometric school class.png') }}">
            </div>
        </div>
    </section>

    <!-- facility -->
    <section id="facility">
        <div class="facility-container">
            <h1>Facilities</h1>
            <p>UIT dormitories are proud to offer modern facilities, fully equipped to meet all the needs of
                students.</p>
            <div class="facility-grid">
                <div class="facility-item">
                    <h2><i class="fa-solid fa-door-open"></i> Room</h2>
                    <p>The rooms at the dormitory are designed to be airy and comfortable, including many types such
                        as single rooms, double rooms and shared rooms.</p>
                </div>
                <div class="facility-item">
                    <h2><i class="fa-brands fa-pagelines"></i> Common living area</h2>
                    <p>Common areas such as living room, reading room and study room, canteen are all modernly
                        equipped.</p>
                </div>
                <div class="facility-item">
                    <h2><i class="fa-solid fa-volleyball"></i> Sports, entertainment</h2>
                    <p>Including soccer field, badminton court, basketball court, ... There is also a gym and a cool
                        park.</p>
                </div>
                <div class="facility-item">
                    <h2><i class="fa-solid fa-shield-halved"></i> Security systems</h2>
                    <p>Equipped with 24/7 security system and professional security team. Regular cleaning service
                        and laundry upon request.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- benefit -->
    <section id="benefit">
        <div class="benefit-container">
            <h1>Benefits</h1>
            <p>Benefits of staying in dormitory.</p>
            <div class="benefit-grid">
                <div class="benefit-item">
                    <img src="{{ asset('images/Highway.png') }}">
                    <h2>Convenience in learning</h2>
                    <p>Close to lecture halls and libraries,
                        easy access to school activities
                        and clubs.</p>
                    <span>01</span>
                </div>
                <div class="benefit-item">
                    <img src="{{ asset('images/Community.png') }}">
                    <h2>International exchange environment</h2>
                    <p>A place to meet and connect students from many different cultures, creating a diverse and
                        friendly academic
                        community.</p>
                    <span>02</span>
                </div>
                <div class="benefit-item">
                    <img src="{{ asset('images/Basketball.png') }}">
                    <h2>Support for learning and life</h2>
                    <p>Support services such as academic advising, events, and extracurricular activities help
                        students balance their lives and studies effectively.</p>
                    <span>03</span>
                </div>
            </div>
        </div>
    </section>

    <!-- about -->
    <section id="about">
        <div class="about-container">
            <h1>About Us</h1>
            <p>The Dormitory of the University of Information Technology (UIT) offers a safe and comfortable living
                space for students, equipped with modern facilities such as study rooms, recreational areas, and
                security systems. It provides an environment that supports both academic pursuits and social
                activities, fostering personal growth.</p>
            <p>The Dormitory Management Center ensures smooth operations and quality services. The team is dedicated
                to creating a supportive and well-organized living environment for all UIT students.</p>
            <div class="team">
                <div class="team-member">
                    <h2>Ms. Minh Vy</h2>
                    <p>Head of the Center, oversees overall management.</p>
                </div>
                <div class="team-member">
                    <h2>Mr. Minh Hoang</h2>
                    <p>Deputy Head, manages logistics and administration.</p>
                </div>
                <div class="team-member">
                    <h2>Ms. Tuong Vi</h2>
                    <p>Leads the Student Affairs Department, focusing on student activities and welfare.</p>
                </div>
                <div class="team-member">
                    <h2>Mr. Nguyen Nam</h2>
                    <p>Head of Security, responsible for the safety of residents.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li><a href="#">Address</a></li>
                    <li><a href="#">Phone</a></li>
                    <li><a href="mailto:email1@example.com">Email 1</a></li>
                    <li><a href="mailto:email2@example.com">Email 2</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#infor">Infor</a></li>
                    <li><a href="#facility">Facilities</a></li>
                    <li><a href="#benefit">Benefits</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Help</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Reporting</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>


</body>
</html>

