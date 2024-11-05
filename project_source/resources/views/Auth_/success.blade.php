@extends('Auth_.index')

@section('content')
    <div class="center_1">
        <div class="card_re" style="height: 200px !important">
            <div
                class="d-flex justify-content-center"
                style="align-items: center"
            >
                <img
                    src="{{asset('./img/img.png')}}"
                    class="mr-3"
                    alt=""
                    style="width: 68px; height: 59px"
                />
                <div class="text-center">
                    <p class="m-0 p_top">TRUNG TÂM QUẢN LÝ KÝ TÚC XÁ</p>
                    <p class="m-0 p_bottom">WEBSITE CHỨNG THỰC</p>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md-12 d-flex" style="justify-content: center">
                    <div style="width: 90% !important">
                        <p
                            style="
                    border-radius: 5px;
                    background: #b4d6f3;
                    color: rgba(0, 0, 0, 0.45);
                    font-weight: 400;
                  "
                            class="mb-0 text-center"
                        >
                            Change password successfully!
                        </p>
                    </div>
                </div>
                <div class="mt-4 text-center col-md-12">
                    <p class="p_register">
                        <u class="ml-2">Login</u>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
