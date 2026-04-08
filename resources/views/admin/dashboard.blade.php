@extends('layouts.app')

@section('content')

<style>
    .wrapper {
        display: flex;
        height: calc(100vh - 80px);
    }

    /* sidebar */
    .sidebar {
        width: 220px;
        background: #d6c5b4;
        padding: 20px;
    }

    .sidebar h3 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 30px;
    }

    .menu {
        margin: 15px 0;
        padding: 10px;
        background: #cbb7a4;
        border-radius: 10px;
    }

    /* content */
    .content {
        flex: 1;
        background: #e8dccf;
        padding: 30px;
    }

    .card {
        background: #f3ebe3;
        padding: 20px;
        border-radius: 20px;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        border-bottom: 2px solid #aaa;
    }

    .btn {
        padding: 5px 10px;
        border-radius: 10px;
        border: none;
        font-size: 12px;
        cursor: pointer;
    }

    .edit { background: #c49a9a; color:white; }
    .hapus { background: #a66; color:white; }
</style>

<div class="wrapper">

    <!-- sidebar -->
    <div class="sidebar">
        <h3>Asha Studio</h3>

        <div class="menu">Dashboard</div>
        <div class="menu">Jadwal</div>
        <div class="menu">Booking</div>
    </div>

    <!-- content -->
    <div class="content">
        <h2>KELOLA JADWAL</h2>

        <div class="card">

            <table>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jadwal</th>
                    <th>Aksi</th>
                </tr>

                @foreach($data as $d)
                <tr>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->email }}</td>
                    <td>{{ $d->jadwal }}</td>
                    <td>
                        <a href="/delete/{{ $d->id }}">
                            <button class="btn hapus">Hapus</button>
                        </a>
                    </td>
                </tr>
                @endforeach

            </table>

        </div>
    </div>

</div>

@endsection