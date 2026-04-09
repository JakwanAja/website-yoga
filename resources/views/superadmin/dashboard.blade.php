@extends('layouts.superadmin')

@section('content')

<style>
    .title {
        font-size: 28px;
        color: #6b3e3e;
        margin-bottom: 20px;
    }

    .cards {
        display: flex;
        gap: 20px;
    }

    .card {
        flex: 1;
        background: rgba(217, 201, 184, 0.9);
        padding: 20px;
        border-radius: 20px;
    }

    .card h3 {
        font-size: 14px;
        color: #6b5a4a;
    }

    .card h1 {
        font-size: 26px;
        color: #6b3e3e;
    }
</style>

<div class="title">SUPER ADMIN DASHBOARD</div>

<div class="cards">
    <div class="card">
        <h3>Total Admin</h3>
        <h1>5</h1>
    </div>

    <div class="card">
        <h3>Total Booking</h3>
        <h1>120</h1>
    </div>

    <div class="card">
        <h3>Total User</h3>
        <h1>80</h1>
    </div>
</div>

@endsection