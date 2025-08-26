<?php
session_start();

require 'functions.php';
cekLogin("admin");

$produk = query("SELECT * FROM produk");
$karyawan = query("SELECT * FROM admin")
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin</title>
</head>

<body>
  <?php if(isset($_SESSION["nama"])): ?>
        <h2>Halo, <?= htmlspecialchars($_SESSION["nama"]); ?></h2>
    <?php endif; ?>
  <a href="logout.php">Logout</a>
  <a href="data_produk.php">Data Produk</a>
  <a href="pelanggan.php">Tambah Data Pelanggan</a>
  <a href="transaksi.php">Transaksi</a>

  <br>
  <table>
      <a href="produk.php">Tambah Produk</a>
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
                <a href="ubah_produk.php?id=<?= $row['ProdukID']; ?>"> Ubah </a> | 
                <a href="hapus_produk.php?id=<?= $row['ProdukID']; ?>" onclick="return confirm('yakin?');"> Hapus</a> 
            </td> 
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
  </table>

  <table>
      <a href="register.php">Tambah karyawan</a>
          <tr>
            <td>Nomer</td>
            <td>NIK</td>
            <td>Nama Karawan</td>
            <td>Alamat</td>
            <td>Level</td>
            <td>Aksi</td>
          </tr>

          <?php $i = 1; ?>
          <?php foreach ($karyawan as $row): ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $row["NIK"]?></td>
            <td><?= $row["Nama"]?></td>
            <td><?= $row["Alamat"]?></td>
            <td><?= $row["Level"]?></td>
            <td>
              <a href="ubah_karyawan.php?id=<?= $row['ID']; ?>"> Ubah </a> | 
              <a href="hapus_karyawan.php?id=<?= $row['ID']; ?>" onclick="return confirm('yakin?');"> Hapus</a> 
            </td>
          </tr>
          <?php $i++; ?>
          <?php endforeach; ?>
  </table>
</body>
</html>