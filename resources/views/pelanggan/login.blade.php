@extends('layouts/main-pelanggan')

@section('link')
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/linericon/style.css">
@endsection

@section('content')
    <!--================Login Box Area =================-->
    <section class="login_box_area section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <div class="hover">
                            <img src="{{ asset('assets-user') }}/img/logo-toko.png" alt="Go Happy Mart Logo"
                                style="width: 200px; margin-bottom: 15px;">

                            <h3 style="color: #fff; font-weight: 700; margin-bottom: 10px;">
                                Selamat Datang di <span style="color: #ffb400;">Go Happy Mart</span>
                            </h3>

                            <p
                                style="
                color: #e8f0ff;
                font-size: 18px;
                font-weight: 500;
                letter-spacing: 0.5px;
                margin-top: 10px;
                font-style: italic;
            ">
                                Belanja Tanpa Ribet
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Log in to enter</h3>
                        <form class="row login_form" action="/akses-login" id="contactForm" method="POST">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="name" name="username"
                                    placeholder="Username" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Username'" value="jamal">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="name" name="password"
                                    placeholder="Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Password'" value="password123">
                            </div>
                            {{-- <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option2" name="selector">
                                    <label for="f-option2">Keep me logged in</label>
                                </div>
                            </div> --}}
                            <div class="col-md-12 form-group text-center">
                                <!-- Lupa Password di atas tombol -->
                                <a href="#"
                                    style="display: block; color:#007bff; text-align: left; font-size: 14px; text-decoration: none; margin-bottom: 20px; margin-top:1vh;">
                                    Lupa Password?
                                </a>

                                <!-- Tombol Login -->
                                <button type="submit" value="submit" class="button button-login w-100 mb-3"
                                    style="font-weight: 600;">
                                    Masuk
                                </button>

                                <!-- Belum punya akun di bawah tombol -->
                                <p style="text-align: left; margin-top:1vh; font-size: 14px;">
                                    Belum punya akun?
                                    <a href="/akun-baru"
                                        style="color: #007bff; text-decoration: none; display: inline; vertical-align: middle;">
                                        Daftar
                                    </a>
                                </p>

                            </div>

                            <div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection

@section('script')
@endsection
