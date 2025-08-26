<?php
session_start();

require 'functions.php';
cekLogin(["admin", "karyawan"]);

$produk = query("SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin</title>
</head>

<body>
    <h1>Data Produk Toko</h1>
  <table>
        <tr>
          <td>Nomer</td>
          <td>Nama Produk</td>
          <td>Harga</td>
          <td>Stock</td>
          <td>Aksi</td>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($produk as $row): ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $row["NamaProduk"]; ?></td>
            <td><?= $row["Harga"]; ?></td>
            <td><?= $row["Stok"]; ?></td>
            <td>
                <a href="ubahProduk.php?ProdukID=<?= $row['ProdukID']; ?>"> Ubah </a> | 
                <a href="hapusProduk.php?PrdukID=<?= $row['ProdukID']; ?>" onclick="return confirm('yakin?');"> Hapus</a> 
            </td> 
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
  </table>

<a href="login.php">Kembali</a>
</body>
</html>