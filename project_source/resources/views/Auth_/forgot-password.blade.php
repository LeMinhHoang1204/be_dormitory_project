@extends('Auth_.index')

@section('content')
    <div class="center_1">

        <div class="card_re" style="height:350px !important;">
            <div class="d-flex justify-content-center " style="align-items: center;">
                <img src="{{asset('./img/img.png')}}" class="mr-3" alt="" style="width: 68px; height: 59px;">
                <div class="text-center">
                    <p class="m-0 p_top">TRUNG TÂM QUẢN LÝ KÝ THÚC XÁ</p>
                    <p class="m-0 p_bottom">WEBSITE CHỨNG THỰC</p>

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="ml-4 mb-2" style="width:90%; color: #0C589C;
                        font-family: Inter;
                        font-size: 12px;
                        font-style: normal;
                        font-weight: 400;
                        line-height: normal;" >
                        Enter your account, the system will send a code via email to help you change your new password.
                    </div>
                </div>
                <div class="col-md-12 " style="display: flex;  justify-content: center;">
                    <div class="justify-content-between" style=" display: flex; width: 90%; align-items: center;">
                        <input type="text" class="form-control" placeholder="Username" style="width:70%;  ">
                        <div style="width:90px !important;">
                            <a href="" class="send_code"><u>Sendcode</u></a>

                        </div>
                    </div>

                </div>
                <div class="col-md-12 " style="display: flex;  justify-content: center; margin-top:20px;">
                    <div class="justify-content-between" style=" display: flex; width: 90%; align-items: center;">
                        <input type="text" class="form-control" placeholder="Verification code"
                               style="width:70%;  ">
                        <button style="padding: 7.527px 17.527px;
                            flex-direction: column;
                            align-items: center;
                            flex-shrink: 0;
                            border-radius: 10px;
                            color:white;
                            background: #2F6BFF
                            ">
                            Confirm
                        </button>
                    </div>

                </div>

                <div class="mt-4 text-center col-md-12">
                    <p class="m-0 p_dont">Or</p>

                    <p class="p_register ">

                        <a href="" class="p_login"><u>Login</u></a>
                </div>

            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginLink = document.querySelector('.p_login');

            if (loginLink) {
                loginLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    window.location.href = "{{ url('/') }}";
                });
            }
        });
    </script>
@endsection
