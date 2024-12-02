<div class="container-fluid layout" style=" box-shadow: 0px 6px 4px 0px  #ECEFFF;height: 70px; flex-shrink: 0;">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-between">
            <div class="col-md-3 d-flex align-items-center">
                <img src="{{asset('./img/img.png')}}" alt="">
                <div class="ml-2">
                    <h2 class="h2_header">KÍ TÚC XÁ</h2>
                    <h3 class="h3_header">Trường ĐH CNTT</h3>
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
                        <!-- Hiển thị tên người dùng nếu đã đăng nhập -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>

                                <!-- Đảm bảo có form đăng xuất khi nhấn vào Logout -->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Log Out</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>

                        </li>
                    @else
                        <!-- Hiển thị Login và Sign up nếu chưa đăng nhập -->
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}" class="border">Sign up</a></li>
                    @endauth
                </ul>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
