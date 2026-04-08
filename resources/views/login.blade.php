@extends('layouts.app')

@section('content')

<style>
    .login-wrapper {
        height: calc(100vh - 80px);
        background: #d8c8b8;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-card {
        width: 600px;
        background: #efe6df;
        padding: 50px;
        border-radius: 25px;
        text-align: center;
        position: relative;
    }

    /* logo bulat atas */
    .logo-circle {
        width: 60px;
        height: 60px;
        background: #efe6df;
        border-radius: 50%;
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
    }

    .title {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        color: #6a2e2e;
        margin-bottom: 40px;
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .form-group input {
        width: 100%;
        padding: 12px 45px;
        border-radius: 15px;
        border: none;
        background: #b98f8f;
        color: white;
        outline: none;
    }

    .form-group input::placeholder {
        color: #f2eaea;
        font-size: 14px;
    }

    /* icon kiri */
    .form-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: white;
    }

    .btn-login {
        margin-top: 10px;
        padding: 12px 35px;
        border: none;
        border-radius: 15px;
        background: #b98f8f;
        color: white;
        cursor: pointer;
    }

    .btn-login:hover {
        background: #a67878;
    }
</style>

<div class="login-wrapper">

    <div class="login-card">

        <div class="logo-circle"></div>

        <div class="title">Asha Studio</div>

        <form action="#" method="POST">
            @csrf

            <!-- Username -->
            <div class="form-group">
                <i></i>
                <input type="text" name="username" placeholder="Silahkan masukan username anda">
            </div>

            <!-- Password -->
            <div class="form-group">
                <i></i>
                <input type="password" name="password" placeholder="Silahkan masukan password anda">
            </div>

            <button class="btn-login">LOGIN</button>

        </form>

    </div>

</div>

@endsection