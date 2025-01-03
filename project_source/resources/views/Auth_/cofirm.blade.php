@extends('Auth_.index')

@section('content')
    <div class="center_1">

            <div class="card_re" style="height:400px !important;">
                <div class="d-flex justify-content-center " style="align-items: center;">
                    <img src="{{asset('./img/img.png')}}" class="mr-3" alt="" style="width: 68px; height: 59px;">
                    <div class="text-center">
                        <p class="m-0 p_top">TRUNG TÂM QUẢN LÝ KÝ TÚC XÁ</p>
                        <p class="m-0 p_bottom">WEBSITE CHỨNG THỰC</p>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 margin-input position-relative" >
                        <input type="password" class="form-control" placeholder="Enter new password" style="width:90% !important;">
                        <button class="check position-absolute" style="width:10% !important;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                              </svg>
                        </button>
                    </div>
                    <div class="col-md-12 margin-input position-relative" >
                        <input type="password" class="form-control" placeholder="Confirm password" style="width:90% !important;">
                        <button class="check position-absolute" style="width:10% !important;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                              </svg>
                        </button>
                    </div>
                    <div class="col-md-12 margin-input text-center d-flex justify-content-center" >
                        <button class="btn_re">
                            <b> Change </b>

                        </button>
                    </div>
                    <div class="mt-4 text-center col-md-12">
                        <p class="m-0 p_dont"><b>Or </b></p>

                        <p class="p_register ">

                           <u class="ml-2">Login</u></p>
                    </div>





                </div>

            </div>
        </div>
@endsection
