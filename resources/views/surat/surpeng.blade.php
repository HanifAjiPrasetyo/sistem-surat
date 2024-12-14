<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .content {
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th,
        .table td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        .date {
            text-align: right;
            margin-right: 50px;
        }

        .signature {
            padding: 0 20px;
        }

        .left {
            float: left;
            text-align: center;
        }

        .right {
            float: right;
            text-align: center;
        }

        .images .ttd {
            margin-left: -20px;
        }

        .images .stamp {
            margin-right: -20px;
        }
    </style>
</head>

<body>
    <h4>KECAMATAN SUKOREJO</h4>
    <h4>KELURAHAN PAKUNDEN</h4>
    <h4>RT 01/RW 01</h4>
    <h4>KOTA BLITAR</h4>

    <center>
        <h4>
            <u>
                SURAT KETERANGAN
            </u>
        </h4>
        <p>No : {{ $record->no_surat }}</p>
    </center>


    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Ketua RT 01/RW 01 Kelurahan Pakunden, Kecamatan Sukorejo, menerangkan
            dengan sebenarnya bahwa :</p>
    </div>

    <table class="table">
        <tr>
            <td>No. KTP/NIK</td>
            <td>:</td>
            <td>{{ $record->userData->nik }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $record->userData->nama }}</td>
        </tr>
        <tr>
            <td>Tempat & Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $record->userData->tempat_lahir . ', ' . strtoupper($record->userData->tgl_lahir) }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $record->userData->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td>Status Perkawinan</td>
            <td>:</td>
            <td>{{ $record->userData->status_perkawinan }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>:</td>
            <td>{{ $record->userData->kewarganegaraan }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $record->userData->agama }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $record->userData->pekerjaan }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $record->userData->alamat }}
            </td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td>{{ strtoupper($record->keperluan) }}</td>
        </tr>
    </table>

    <div class="date">
        <p>Blitar, {{ Carbon::parse($record->created_at)->translatedFormat('d F Y') }}</p>
    </div>

    <div class="signature">
        <div class="left">
            <p>Mengetahui,</p>
            <p>Ketua RW 01,</p>
            <div class="images">
                <img class="stamp" src="storage/{{ $stampRT->path }}" alt="Stempel RT" width="70" height="60">
                <img class="ttd" src="storage/{{ $ttdRT->path }}" alt="TTD RT" width="70" height="60">
            </div>
            <p>( {{ $rw->name }} )</p>
        </div>
        <div class="right">
            <p>Mengetahui,</p>
            <p>Ketua RT 01,</p>
            <div class="images">
                <img class="stamp" src="storage/{{ $stampRW->path }}" alt="Stempel RW" width="70" height="60">
                <img class="ttd" src="storage/{{ $ttdRW->path }}" alt="TTD RW" width="70" height="60">
            </div>
            <p>( {{ $rt->name }})</p>
        </div>
    </div>

</body>

</html>
