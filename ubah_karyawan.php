<?php
session_start();
require 'functions.php';
// Cek apakah user sudah login 
if( !isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT MAX(nik) AS nik_terakhir FROM admin");
$data = mysqli_fetch_assoc($query);
$nik_terakhir = $data['nik_terakhir'];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$karyawan = ($id > 0) ? query("SELECT * FROM admin WHERE ID = $id")[0] : null;

// // Kalau ada data, tambahkan 1, kalau belum ada mulai dari 20200801
// if ($nik_terakhir) {
//     $nik_baru = strval(intval($nik_terakhir) + 1);
// } else {
//     $nik_baru = "20200801"; // NIK awal
// }


$dataanggota = query("SELECT * FROM admin");
if(isset($_POST["submit"])) {

    if(ubah($_POST) > 0 ){
        echo "<script>
            alert('Data berhasil ubah!');
            
            document.location.href = 'admin.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ubah!');
            document.location.href = 'admin.php';
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
            <div>Silahkan isi data Karyawan</div>

            <form action="" method="post" enctype="multipart/form-data">

                <input type="hidden" name="ID" value="<?= $karyawan['ID'] ?>">
                <label for="NIK">NIK</label>
                <input type="text" name="NIK" id="NIK" value="<?= $karyawan["NIK"]?>" readonly> <br>

                <label for="Nama">Nama</label>
                <input id="Nama" type="text" name="Nama" autocomplete="off" require
                value="<?= $karyawan["Nama"]?>"> <br>

                <label for="Alamat">Alamat</label>
                <input id="Alamat" type="text" name="Alamat" autocomplete="off" require
                value="<?= $karyawan["Alamat"]?>"><br>

                <label for="Password">Password</label>
                <input id="Password" type="password" name="Password" autocomplete="off" require
                value="<?= $karyawan["Password"]?>"> <br>

                <div>
                <label>Level</label>
                        <input type="radio" name="Level" value="admin" required
                        <?= $karyawan['Level'] == 'admin' ? 'checked' : '' ?>> Admin
                        <input type="radio" name="Level" value="karyawan" required
                        <?= $karyawan['Level'] == 'karyawan' ? 'checked' : '' ?>> Karyawan
                </div>

                <button type="submit" name="submit" class="submit">Kirim Data</button>
        </div>
</body>
</html>