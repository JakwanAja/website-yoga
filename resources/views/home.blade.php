@extends('layouts.app')

@section('content')

<style>
    body {
        margin: 0;
        background-color: #e8dccf;
        font-family: 'Georgia', serif;
    }

    /* HERO */
    .hero {
        display: flex;
        height: calc(100vh - 70px);
    }

    .hero-left {
    width: 50%;
    padding-left: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%; 
    }

    .title {
        font-family: 'Lavishly Yours', cursive;
        font-style: italic;
        font-size: 60px;
        color: #6b3e3e;
        margin-bottom: 30px;
    }

    .subtitle {
        font-size: 24px;
        color: #6b3e3e;
        line-height: 1.5;
        margin-bottom: 40px;
    }

    .buttons {
        display: flex;
        gap: 20px;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 25px;
        border: none;
        background-color: #c49a9a;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #b58383;
    }

    /* RIGHT IMAGE */
    .hero-right {
        width: 50%;
        position: relative;
    }

    .hero-right img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.8;
    }
</style>


    <div class="logo">
    </div>
</div>

<!-- HERO -->
<div class="hero">

    <!-- LEFT -->
    <div class="hero-left">
        <div class="title">Asha Studio</div>

        <div class="subtitle">
            Temukan<br>
            Keseimbangan Tubuh<br>
            dan Pikiran Anda
        </div>

        <div class="buttons">
            <button class="btn">Booking</button>
            <button class="btn">Schedule</button>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="hero-right">
        <img src="{{ asset('images/yoga.png') }}" alt="Yoga">
    </div>

</div>

@endsection