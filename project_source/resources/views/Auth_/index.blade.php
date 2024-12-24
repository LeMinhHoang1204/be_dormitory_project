<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('./img/img.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/brands.min.css" />

    {{-- font --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- WEBSITE: tabler icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



</head>

@if (session('notification'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const notification = @json(session('notification'));
            // Display the notification
            toastr.info(
                `${notification.message} `
            );
        });
    </script>
@endif

<style>
    ul {
        list-style: none;
    }

    .style_header {
        display: flex;
        width: var(--cursorSpeed, 100px);
        height: 35px;
        flex-direction: column;
        justify-content: center;
        flex-shrink: 0;
    }

    .ul li a {
        color: #0E3B9C;

        font-family: Poppins;
        font-size: 15px;
        font-style: normal;
        font-weight: 600;
        line-height: 22.4px;
    }

    .text-center {
        font-family: 'Roboto', sans-serif;
    }

    .h3_header {
        /*color: #2F6BFF;*/
        color: #0e3b9c;

        font-size: 15px;
        font-style: normal;
        font-weight: 500;
        line-height: 12px;
        font-family: 'Poppins', sans-serif;
        width: 300px;
        /*border: #0C589C 1px solid;*/
    }

    .h2_header {
        /*color: #2F6BFF;*/
        color: #0e3b9c;

        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 12px;
    }

    .border {
        border-radius: 5px;
        border: 1px solid #0E3B9C !important;
        background: #FFF;
        display: inline-flex;
        padding: 9px 11px 8px 11px;
        justify-content: center;
        align-items: center;
    }

    .layout {
        height: 70px;
        margin-top: 10px;



    }

    .card_re {

        width: 450px;
        padding: 19px 20px 153px 20px;
        height: 800px;
        align-items: center;
        border-radius: 10px;
        background: #FFF;
        box-shadow: 5px 9px 20px 10px rgba(0, 0, 0, 0.25);



    }

    .margin-input {
        margin-top: 20px;
    }

    .btn_re {
        display: flex;
        width: 127px;
        height: 46px;
        padding: 17px 25px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        border-radius: 10px;
        background: #2F6BFF;
        border: none;
        color: white;

        text-align: center;
        justify-content: center;
    }

    .text-center {
        font-family: 'Inter', sans-serif;
    }

    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        margin: 0 auto;
        margin-top: 40px !important;
        margin-bottom: 40px !important;


    }

    .center_1 {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        /* Full viewport height */
        margin: 0 auto;
    }

    .p_top {
        color: #3C3C3C;
        text-align: center;
        font-family: Roboto;
        font-size: 15px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .p_bottom {
        color: #1D81D5;
        font-family: Roboto;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal
    }

    .margin-input input {
        width: 90%;

    }

    .margin-input {
        display: flex;
        justify-content: center;
    }

    .change {
        color: #0C589C;
        text-align: center;
        font-family: Inter;
        font-size: 12px;
        font-style: italic;
        font-weight: 400;
        line-height: normal;
        text-decoration-line: underline;
    }

    .forgot {
        color: #0C589C;
        text-align: center;
        font-family: Inter;
        font-size: 12px;
        font-style: italic;
        font-weight: 400;
        line-height: normal;
        text-decoration-line: underline;
    }

    .p_register {
        color: #0C589C;
        font-family: Inter;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 22.4px;
        text-decoration-line: underline
    }

    .p_dont {
        color: #000;
        text-align: center;
        font-family: Inter;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 22.4px;
    }

    .check {
        border: none;
        right: 35px;
        top: 5px;
        background: none;
    }

    .send_code {
        color: #3C3C3C;
        text-align: center;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: 22.4px;
        /* 186.667% */
        text-decoration-line: underline;


    }
</style>

<body>
    <div>
        @include('Auth_.layout')
        @yield('content')
    </div>


</body>

</html>
