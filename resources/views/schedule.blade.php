@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #e8dccf;
        font-family: 'Georgia', serif;
    }

    /* Header */
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
        font-size: 40px;
        font-style: italic;
        color: #6b3e3e;
    }

    /* Schedule Container */
    .schedule-container {
        margin: 30px 40px;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }

    /* Background image */
    .schedule-bg {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.25;
    }

    /* Table */
    .schedule-table {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background-color: rgba(217, 201, 184, 0.85);
        position: relative;
        z-index: 2;
    }

    .day {
        text-align: center;
        padding: 15px;
        font-weight: bold;
        font: 'Georgia', serif;
        border-right: 1px solid #6b5a4a;
    }

    .day:last-child {
        border-right: none;
    }

    .content {
        padding: 15px;
        border-right: 1px solid #6b5a4a;
        border-top: 1px solid #6b5a4a;
        font-size: 13px;
        line-height: 1.6;
    }

    .content:last-child {
        border-right: none;
    }
</style>

<!-- Header -->
<div class="header">
    <div class="title">SCHEDULE</div>
    <div class="studio">Asha Studio</div>
</div>

<!-- Schedule -->
<div class="schedule-container">

    <!-- Background -->
    <img src="{{ asset('images/yoga-bg.jpg') }}" class="schedule-bg">

    <!-- Table -->
    <div class="schedule-table">

        <!-- Header Hari -->
        <div class="day">SENIN</div>
        <div class="day">RABU</div>
        <div class="day">JUMAT</div>
        <div class="day">MINGGU</div>

        <!-- Isi -->
        <div class="content">
            08.00 - Beginner Yoga<br>
            12.15 - Yoga Relax & Stretch<br>
            16.30 - Pilates Core Strength<br>
            20.45 - Beginner Yoga<br>
            20.10 - Pilates Core Strength
        </div>

        <div class="content">
            10.00 - Pilates Core Strength<br>
            15.15 - Beginner Yoga<br>
            17.10 - Yoga Relax & Stretch<br>
            19.25 - Pilates Core Strength<br>
            21.00 - Beginner Yoga
        </div>

        <div class="content">
            08.00 - Yoga Relax & Stretch<br>
            13.00 - Beginner Yoga<br>
            16.30 - Pilates Core Strength<br>
            20.45 - Beginner Yoga<br>
            20.10 - Pilates Core Strength
        </div>

        <div class="content">
            10.00 - Beginner Yoga<br>
            15.15 - Pilates Core Strength<br>
            17.10 - Beginner Yoga<br>
            19.25 - Yoga Relax & Stretch<br>
            21.00 - Pilates Core Strength
        </div>

    </div>

</div>

@endsection