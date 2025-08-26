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

    if(Produk($_POST) > 0 ){
        echo "<script>
            alert('Produk berhasil ditambahkan!');
            
            document.location.href = 'produk.php';
        </script>";
    } else {
        echo "<script>
            alert('Produk gagal ditambahkan!');
            document.location.href = 'produk.php';
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
            <div>Silahkan isi data Produk</div>

            <form action="" method="post" enctype="multipart/form-data">

                <label for="Nama">Nama Produk</label>
                <input type="text" name="Nama" id="Nama" autocomplete="off" require> <br>

                <label for="Harga">Harga</label>
                <input id="Harga" type="text" name="Harga" autocomplete="off" require> <br>

                <label for="Stok">Stok</label>
                <input id="Stok" type="text" name="Stok" autocomplete="off" require><br>

                <button type="submit" name="submit" class="submit">Kirim Data</button>
        </div>
         <!-- <script>
        const input = document.getElementById("Harga");

        input.addEventListener("input", function(e) {
            let value = e.target.value;
            value = value.replace(/[^\d]/g, ""); // hapus semua kecuali angka
            if (value) {
                e.target.value = formatRupiah(value);
            } else {
                e.target.value = "";
            }
        });

        function formatRupiah(angka) {
            return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script> -->
</body>
</html>