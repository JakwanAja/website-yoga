@extends('layouts.admin')

@section('content')

<style>
    body {
        background-color: #e8dccf;
        font-family: 'Georgia', serif;
    }

    .dashboard {
        padding: 30px;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .title {
        font-size: 28px;
        color: #6b3e3e;
    }

    .studio {
        font-family: 'Lavishly Yours', cursive;
        font-size: 28px;
        color: #6b3e3e;
        font-style: italic;
    }

    /* Cards */
    .cards {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        flex: 1;
        background: rgba(217, 201, 184, 0.85);
        padding: 20px;
        border-radius: 20px;
        border: 1px solid #6b5a4a;
    }

    .card h3 {
        font-size: 14px;
        color: #6b5a4a;
        margin-bottom: 10px;
    }

    .card h1 {
        font-size: 26px;
        color: #6b3e3e;
    }

    /* Table */
    .table-container {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }

    .table-bg {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.2;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(217, 201, 184, 0.9);
        position: relative;
        z-index: 2;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #6b5a4a;
    }

    th {
        color: #6b3e3e;
        font-weight: bold;
    }

    td {
        font-size: 14px;
        color: #5a2e2e;
    }

    /* Status */
    .status {
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 12px;
    }

    .success {
        background: #d4e6d4;
        color: #2f5d2f;
    }

    .pending {
        background: #f3e1c7;
        color: #8a6d3b;
    }
</style>

<div class="dashboard">

    <!-- Header -->
    <div class="header">
        <div class="title">ADMIN DASHBOARD</div>
        <div class="studio">Asha Studio</div>
    </div>

    <!-- Statistik -->
    <div class="cards">
        <div class="card">
            <h3>Total Booking</h3>
            <h1>120</h1>
        </div>

        <div class="card">
            <h3>Total User</h3>
            <h1>80</h1>
        </div>

        <div class="card">
            <h3>Kelas Aktif</h3>
            <h1>6</h1>
        </div>
    </div>

    <!-- Table -->
    <div class="table-container">

        <!-- Background -->
        <img src="{{ asset('images/yoga-bg.jpg') }}" class="table-bg">

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Kelas</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Irma</td>
                    <td>irma@email.com</td>
                    <td>08123456789</td>
                    <td>Beginner Yoga</td>
                    <td><span class="status success">Sukses</span></td>
                </tr>

                <tr>
                    <td>Budi</td>
                    <td>budi@email.com</td>
                    <td>08234567890</td>
                    <td>Pilates Core</td>
                    <td><span class="status pending">Pending</span></td>
                </tr>
            </tbody>
        </table>

    </div>

</div>

@endsection
