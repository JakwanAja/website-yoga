@extends('layouts.app')

@section('content')

<style>
.wrapper {
    display: flex;
    height: calc(100vh - 80px);
}

/* SIDEBAR */
.sidebar {
    width: 220px;
    background: #d6c5b4;
    padding: 20px;
}

.sidebar h2 {
    font-family: 'Playfair Display', serif;
    margin-bottom: 30px;
}

.menu {
    padding: 10px;
    margin: 10px 0;
}

.menu.active {
    background: #cbb7a4;
    border-radius: 10px;
}

/* CONTENT */
.content {
    flex: 1;
    background: #e8dccf;
    padding: 30px;
}

.header {
    text-align: center;
    margin-bottom: 20px;
    color: #7a2e2e;
}

.card {
    background: #f3ebe3;
    padding: 25px;
    border-radius: 20px;
}

/* BUTTON */
.btn-add {
    float: right;
    background: #cbb7a4;
    border: none;
    padding: 8px 15px;
    border-radius: 10px;
    cursor: pointer;
}

/* TABLE */
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
    border: none;
    border-radius: 10px;
    font-size: 12px;
    cursor: pointer;
}

.edit {
    background: #c49a9a;
    color: white;
}

.hapus {
    background: #a66;
    color: white;
}
</style>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Asha Studio</h2>

        <div class="menu">User</div>
        <div class="menu">Dashboard</div>
        <div class="menu">Jadwal</div>
        <div class="menu active">Booking</div>

        <br>
        <button class="menu">Logout</button>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="header">
            <h3>KELOLA BOOKING</h3>
        </div>

        <div class="card">

            <button class="btn-add">+ Tambah Booking</button>

            <table>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

                <tr>
                    <td>Nur Azizah</td>
                    <td>nur@gmail.com</td>
                    <td>Senin 08.00</td>
                    <td>Pending</td>
                    <td>
                        <button class="btn edit">Edit</button>
                        <button class="btn hapus">Hapus</button>
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection