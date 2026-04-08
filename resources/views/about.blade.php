@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #e8dccf;
        font-family: 'Georgia', serif;
    }

    .about-container {
        display: flex;
        height: calc(100vh - 80px);
    }

    .about-left {
        width: 50%;
    }

    .about-left img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .about-right {
        width: 50%;
        background-color: #e9ded4;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
    }

    .about-title {
        font-family: 'Lavishly Yours', cursive;
        font-style: italic;
        font-size: 48px;
        color: #5a2e2e;
        margin-bottom: 20px;
    }

    .about-subtitle {
        font-size: 24px;
        color: #5a2e2e;
        margin-bottom: 20px;
    }

    .about-text {
        font-size: 16px;
        color: #5a2e2e;
        line-height: 1.7;
        max-width: 500px;
    }

    .location {
        margin-top: 20px;
        font-size: 14px;
        color: #5a2e2e;
    }
</style>

<div class="about-container">

    <div class="about-left">
        <img src="{{ asset('images/studio.jpg') }}">
    </div>

    <div class="about-right">
        <div class="about-title">Asha Studio</div>

        <div class="about-subtitle">
            Selamat datang di studio <br>
            Pilates & Yoga kami.
        </div>

        <div class="about-text">
            Kami menyediakan kelas yang dirancang untuk membantu meningkatkan fleksibilitas,
            kekuatan tubuh, serta ketenangan pikiran melalui latihan yang dipandu oleh instruktur profesional.
        </div>

        <div class="location">
            Surakarta
        </div>
    </div>

</div>

@endsection