<?php
session_start();
require 'functions.php';
// Cek apakah user sudah login 
if( !isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

$dataanggota = query("SELECT * FROM admin");
if(isset($_POST["submit"])) {
    if(tambahPelanggan($_POST) > 0 ){
        echo "<script>
            alert('Pelanggan berhasil ditambahkan!');
            document.location.href = 'pelanggan.php';
        </script>";
    } else {
        echo "<script>
            alert('Pelanggan gagal ditambahkan!');
            document.location.href = 'pelanggan.php';
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
</head>
<body>
    <div class="form-container">
        <a href="admin.php" class="button">Kembali</a>

        <div class="form">
            <div>Silahkan isi data Pelanggan</div>

            <form action="" method="post" enctype="multipart/form-data">

                <label for="Nama">Nama Pelanggan</label>
                <input type="text" name="Nama" id="Nama" autocomplete="off" required> <br>

                <label for="Alamat">Alamat</label>
                <input id="Alamat" type="text" name="Alamat" autocomplete="off" required> <br>

                <label for="Nomer_Telepon">Nomor Telepon</label>
                <input id="Nomer_Telepon" type="text" name="Nomer_Telepon" autocomplete="off" required><br>

                <button type="submit" name="submit" class="submit">Kirim Data</button>
        </div>
</body>
</html>