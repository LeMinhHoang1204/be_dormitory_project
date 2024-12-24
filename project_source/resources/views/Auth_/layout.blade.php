<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .dropdown-toggle {
            font-family: 'Poppins', sans-serif !important;
            font-size: 16px !important;
        }
        /* Định dạng chung cho nút */
        .navbar a {
            font-size: 16px;
            font-weight: 600;
            color: #4a4a4a;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
        }

        /* Nút Login */
        .navbar .login {
            padding: 4px 8px;
            border: 2px solid transparent;
            border-radius: 8px;
        }

        .navbar .login:hover {
            background-color: #f0f0f5;
            color: #007bff;
            border-color: #007bff;
        }

        /* Nút Sign up */
        .navbar .border {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            border: none;
        }

        .navbar .border:hover {
            background-color: #0056b3;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<div class="container-fluid layout" style=" box-shadow: 0px 6px 4px 0px  #ECEFFF;height: 70px; flex-shrink: 0;">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-between">
            <div class="col-md-3 d-flex align-items-center">
                <img src="{{asset('./img/img.png')}}" alt="">
                <div class="ml-2">
                    <h2 class="h2_header">Dormitory</h2>

                    <h3 class="h3_header">University of Information Technology</h3>

                </div>
            </div>
            <div class="col-md-5">
{{--                <ul class="ul d-flex justify-content-between">--}}
{{--                    <li><a href="{{ route('home') }}">Home</a></li> <!-- Đến trang home -->--}}
{{--                    <li><a href="#">Room</a></li>--}}
{{--                    <li><a href="#">Service</a></li>--}}
{{--                    <li><a href="#">About</a></li>--}}
{{--                </ul>--}}
            </div>

            <div class="col-md-3">
                <ul class="ul d-flex justify-content-between align-items-center navbar">
                    @auth

                        <li class="dropdown">
                            <img src="{{
            auth()->user()->profile_image_path && file_exists(storage_path('app/public/' . auth()->user()->profile_image_path))
            ? asset('storage/' . auth()->user()->profile_image_path)
            : asset('images/avatar.png')  }}"
                                 alt="User Avatar"
                                 class="rounded-circle mr-2"
                                 style="width: 25px; height: 25px; object-fit: cover">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>


                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Account</a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Log Out</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="login" style="margin-left: 30px; text-decoration: none;">Login</a></li>
                        <li><a href="{{ route('register') }}" class="border" style="margin-right: 50px!important; border-radius: 10px!important; padding: 5px; text-decoration: none;">Sign up</a></li>
                    @endauth
                </ul>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
