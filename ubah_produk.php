<?php
session_start();
require 'functions.php';
// Cek apakah user sudah login 
if( !isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

// ...existing code...
$dataanggota = query("SELECT * FROM admin");
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $produk = query("SELECT * FROM produk WHERE ProdukID = $id");
    if ($produk) {
        $produk = $produk[0];
    } else {
        $produk = ["NamaProduk"=>"", "Harga"=>"", "Stok"=>""];
    }
} else {
    $produk = ["NamaProduk"=>"", "Harga"=>"", "Stok"=>""];
}
if(isset($_POST["submit"])) {

    if(Produk_ubah($_POST) > 0 ){
        echo "<script>
            alert('Produk berhasil diubah!');
            
            document.location.href = 'produk.php';
        </script>";
    } else {
        echo "<script>
            alert('Produk gagal diubah!');
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
                <input type="hidden" name="ID" value="<?= $produk["ProdukID"] ?>">
                <label for="Nama">Nama Produk</label>
                <input type="text" name="Nama" id="Nama" autocomplete="off" required
                value="<?= htmlspecialchars($produk["NamaProduk"]) ?>"> <br>

                <label for="Harga">Harga</label>
                <input id="Harga" type="text" name="Harga" autocomplete="off" required
                value="<?= htmlspecialchars($produk["Harga"]) ?>"> <br>

                <label for="Stok">Stok</label>
                <input id="Stok" type="text" name="Stok" autocomplete="off" required
                value="<?= htmlspecialchars($produk["Stok"]) ?>"><br>

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