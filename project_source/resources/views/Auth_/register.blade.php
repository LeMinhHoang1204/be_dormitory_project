@extends('Auth_.index')

@section('content')
    <div class="center">

        <div class="card_re">
            <div class="d-flex justify-content-center " style="align-items: center;">
                <img src="{{asset('./img/img.png')}}" class="mr-3" alt="" style="width: 68px; height: 59px;">
                <div class="text-center">
                    <p class="m-0 p_top">TRUNG TÂM QUẢN LÝ KÝ TÚC XÁ</p>
                    <p class="m-0 p_bottom">WEBSITE ĐĂNG KÝ</p>

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12" style="margin-top:30px; display: flex; justify-content: center;">
                    <input type="text" class="form-control" placeholder="Fullname" style="width:90%;  ">
                </div>
                <div class="col-md-12 margin-input" >


                    <select class="form-control" name="" id="" style="width: 90%;">
                        <option value="" disabled selected>Choose University</option>
                        <option value="DHQGHN">Đại học Quốc gia Hà Nội</option>
                        <option value="DHQGTPHCM">Đại học Quốc gia TP.HCM</option>
                        <option value="BKHN">Đại học Bách khoa Hà Nội</option>
                        <option value="BKHCM">Đại học Bách khoa TP.HCM</option>
                        <option value="KTQD">Đại học Kinh tế Quốc dân</option>
                        <option value="FTU">Đại học Ngoại thương</option>
                        <option value="UEH">Đại học Kinh tế TP.HCM</option>
                        <option value="YHN">Đại học Y Hà Nội</option>
                        <option value="YTPHCM">Đại học Y Dược TP.HCM</option>
                    </select>
                </div>
                <div class="col-md-12 margin-input" >
                    <input type="text" class="form-control" placeholder="Student ID">
                </div>
                <div class="col-md-12 margin-input" >
                    <input type="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-12 margin-input" >
                    <input type="text" class="form-control" placeholder="Phone number">
                </div>
                <div class="col-md-12 margin-input" >
                    <input type="date" class="form-control" placeholder="Date of birth">
                </div>
                <div class="col-md-12 margin-input" >
                    <select class="form-control" name="" id="" style="width: 90%;">
                        <option value="" disabled selected>Choose Gender</option>
                        <option value="Male">male</option>
                        <option value="female">Female</option>


                    </select>
                </div>
                <div class="col-md-12 margin-input position-relative">
                    <input type="password" class="form-control password-field" placeholder="Password" style="width:90% !important;">
                    <button class="check position-absolute toggle-password" style="width:10% !important;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                </div>
                <div class="col-md-12 margin-input position-relative">
                    <input type="password" class="form-control password-field" placeholder="Confirm Password" style="width:90% !important;">
                    <button class="check position-absolute toggle-password" style="width:10% !important;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                </div>
                <div class="col-md-12 margin-input text-center d-flex justify-content-center" >
                    <button class="btn_re">
                        Register
                    </button>
                </div>

            </div>

        </div>
    </div>


@endsection
