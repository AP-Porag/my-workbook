<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon"
          href="{{ \Illuminate\Support\Facades\Storage::url(config('settings.site_favicon') ?? '' )}}">
    <title>Login | {{ config('settings.site_title') ?? config('app.name') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('adminlogin/') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('adminlogin/') }}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('adminlogin/') }}/vendors/linericon/style.css">

    <!-- Extra Plugin CSS -->

    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('adminlogin/') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('adminlogin/') }}/css/responsive.css">

    <style>
        .ic_main_form_area:before {
            background: none !important;
        }
    </style>
</head>

<body class="body_color">

<!--================Login Form Area =================-->
<section class="ic_main_form_area">
    <div class="container">
        <div class="ic_main_form_inner">
            <div class="row">
                <div class="col-lg-6 col-md-5">
                    <div class="form_img">
                        @if(config('settings.login_backgroud'))
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url(config('settings.login_backgroud') ?? '' )}}"
                                alt="img">
                        @else
                            <img src="{{ asset('adminlogin/') }}/imgs/login-default.png" alt="img">
                        @endif

                    </div>
                </div>
                <div class="col-lg-6 col-md-7 d-flex">
                    <div class="form_box">
                        @if(config('settings.site_logo'))
                            <img width="64px" style="margin-bottom: 10px;"
                                 src="{{ \Illuminate\Support\Facades\Storage::url(config('settings.site_logo') ?? '' )}}"
                                 alt="logo">
                        @else
                            <img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
                        @endif

                        <h5>Login</h5>


                        @if(session()->has('loginFail'))
                            <p class="alert alert-danger" style="text-align: center;">
                                {{ session()->get('loginFail') }}
                            </p>
                        @endif


                        <form class="row login_form" action="{{ url('/admin/login') }}" method="post"
                              id="contactForm" novalidate="novalidate">

                            @csrf

                            <div class="form-group col-lg-12">
                                <input type="email" class="form-control" id="name" name="email"
                                       placeholder="demo@gmail.com">
                                <i class="fa fa-user-o"></i>
                                @if ($errors->has('email'))
                                    <p style="color:#77021d">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Password">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                @if ($errors->has('password'))
                                    <p style="color:#77021d">{{ $errors->first('password') }}</p>
                                @endif
                            </div>

                            <div class="form-group col-lg-12">
                                <button type="submit" value="submit" class="btn submit_btn form-control">Login in my
                                    account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">© {{ date('Y') }} All Right Reserved</div>
    </div>
</section>
<!--================End Login Form Area =================-->


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('adminlogin/') }}/js/jquery-3.3.1.min.js"></script>
<script src="{{ asset('adminlogin/') }}/js/popper.min.js"></script>
<script src="{{ asset('adminlogin/') }}/js/bootstrap.min.js"></script>
<!-- Extra Plugin CSS -->
<script src="{{ asset('adminlogin/') }}/vendors/nice-select/js/jquery.nice-select.min.js"></script>

<script src="{{ asset('adminlogin/') }}/js/theme-dist.js"></script>
</body>

</html>
