@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #e8dccf;
        font-family: 'Georgia', serif;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 30px 40px 10px;
    }

    .title {
        font-size: 28px;
        color: #6b3e3e;
        text-underline-offset: 5px;
        
    }

    .studio {
        font-family: 'Lavishly Yours', cursive;
        font-style: italic;
        float: right;
        margin-right: 40px;
        font-size: 28px;
        font-style: italic;
        color: #6b3e3e;
    }

    .card-container {
        display: flex;
        justify-content: space-around;
        margin: 40px;
        gap: 20px;
    }

    .card {
        background-color: #d9c9b8;
        border-radius: 15px;
        padding: 20px;
        width: 300px;
        text-align: center;
    }

    .card img {
        width: 100%;
        border-radius: 10px;
    }

    .card h3 {
        margin-top: 15px;
        color: #6b3e3e;
    }

    .card p {
        font-size: 12px;
        color: #5a4a42;
        margin: 10px 0;
    }

    .btn-book {
        background-color: #b78b8b;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        cursor: pointer;
    }

    .btn-book:hover {
        background-color: #a07070;
    }
</style>


<!-- Title -->
<div class="header">
    <div class="title">CLASS</div>
    <div class="studio">Asha Studio</div>
</div>


<!-- Cards -->
<div class="card-container">

    <!-- Card 1 -->
    <div class="card">
        <h3>Beginner Yoga</h3>
        <img src="{{ asset('images/yoga1.jpeg') }}" alt="Beginner Yoga">
        <p>
            Kelas yoga untuk pemula yang ingin mengenal dasar-dasar yoga
            seperti teknik pernapasan, peregangan tubuh, dan keseimbangan.
        </p>
        <button class="btn-book">Booking</button>
    </div>

    <!-- Card 2 -->
    <div class="card">
        <h3>Pilates Core Strength</h3>
        <img src="{{ asset('images/yoga2.jpeg') }}" alt="Pilates">
        <p>
            Kelas pilates yang berfokus pada penguatan otot inti (core)
            untuk meningkatkan stabilitas tubuh dan memperbaiki postur.
        </p>
        <button class="btn-book">Booking</button>
    </div>

    <!-- Card 3 -->
    <div class="card">
        <h3>Yoga Relax</h3>
        <img src="{{ asset('images/yoga3.jpeg') }}" alt="Relax Yoga">
        <p>
            Kelas yoga yang berfokus pada relaksasi tubuh dan pikiran
            melalui gerakan lembut dan teknik pernapasan.
        </p>
        <button class="btn-book">Booking</button>
    </div>

</div>

@endsection