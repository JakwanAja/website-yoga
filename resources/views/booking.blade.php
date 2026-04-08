@extends('layouts.app')

@section('content')

<style>
    .booking-wrapper {
        height: calc(100vh - 80px);
        background: #e6dbcf;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .booking-card {
        width: 600px;
        background: #f3ebe3;
        padding: 40px 50px;
        border-radius: 25px;
    }

    .booking-title {
        text-align: center;
        font-family: 'Playfair Display', serif;
        color: #7a2e2e;
        font-size: 22px;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    .booking-sub {
        font-size: 16px;
        margin-bottom: 20px;
        color: #5a2e2e;
        border-bottom: 1px solid #5a2e2e;
        width: fit-content;
        padding-bottom: 5px;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-group label {
        width: 100px;
        font-size: 14px;
        color: #5a2e2e;
    }

    .form-control {
        flex: 1;
        padding: 10px 15px;
        border-radius: 20px;
        border: none;
        background: #d6bcbc;
        color: #5a2e2e;
        outline: none;
    }

    .form-control::placeholder {
        color: #7a5a5a;
        font-size: 13px;
    }

    .select-box {
        flex: 1;
        position: relative;
    }

    .select-box select {
        width: 100%;
        padding: 10px 15px;
        border-radius: 20px;
        border: none;
        background: #d6bcbc;
        color: #5a2e2e;
        appearance: none;
        outline: none;
    }

    .select-box::after {
        content: "▼";
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        color: #5a2e2e;
    }

    .schedule-preview {
        margin-top: 10px;
        background: #b88989;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
        color: white;
        font-size: 14px;
    }
</style>

<div class="booking-wrapper">

    <div class="booking-card">

        <div class="booking-title">FORMULIR BOOKING</div>

        <div class="booking-sub">Beginner Yoga</div>

        <form action="#" method="POST">
            @csrf

            <!-- Nama -->
            <div class="form-group">
                <label>NAMA :</label>
                <input type="text" name="nama" class="form-control" placeholder="Silahkan isi nama anda">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>EMAIL :</label>
                <input type="email" name="email" class="form-control" placeholder="Silahkan isi email anda">
            </div>

            <!-- Jadwal -->
            <div class="form-group">
                <label>Jadwal :</label>

                <div class="select-box">
                    <select name="jadwal" onchange="updateJadwal(this)">
                        <option value="">Pilih jadwal</option>
                        <option value="Senin , 08.00 WIB">Senin , 08.00 WIB</option>
                        <option value="Rabu , 10.00 WIB">Rabu , 10.00 WIB</option>
                        <option value="Jumat , 16.00 WIB">Jumat , 16.00 WIB</option>
                    </select>
                </div>
            </div>

            <!-- Preview Jadwal -->
            <div id="preview" class="schedule-preview" style="display:none;"></div>

        </form>

    </div>

</div>

<script>
    function updateJadwal(select) {
        let preview = document.getElementById("preview");

        if(select.value !== "") {
            preview.style.display = "block";
            preview.innerText = select.value;
        } else {
            preview.style.display = "none";
        }
    }
</script>

@endsection