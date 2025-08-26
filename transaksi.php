<?php
session_start();            // penting banget
require 'functions.php';

$success = '';
$errors = array();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // inisialisasi cart
}

// ambil data pelanggan & produk
$pelanggan = query('SELECT PelangganID, NamaPelanggan FROM pelanggan ORDER BY NamaPelanggan');
$produk    = query('SELECT ProdukID, NamaProduk, Harga, Stok FROM produk ORDER BY NamaProduk');

// --- proses form ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_item') {
        $produk_id = (int)$_POST['produk_id'];
        $qty       = (int)$_POST['qty'];

        // ambil produk dari DB
        $p = query("SELECT ProdukID, NamaProduk, Harga FROM produk WHERE ProdukID=$produk_id");
        if ($p) {
            $p = $p[0];
            cart_add($p['ProdukID'], $p['NamaProduk'], $p['Harga'], $qty);
            $success = "Produk berhasil ditambahkan ke keranjang.";
        } else {
            $errors[] = "Produk tidak ditemukan.";
        }
    }

    if ($action === 'remove_item') {
        $produk_id = (int)$_POST['produk_id'];
        cart_remove($produk_id);
        $success = "Produk berhasil dihapus dari keranjang.";
    }

    if ($action === 'checkout') {
        if (empty($_POST['pelanggan_id'])) {
            $errors[] = "Pelanggan harus dipilih.";
        } else {
            $pelangganId = (int)$_POST['pelanggan_id'];
            $penjualanId = tambahTransaksi($pelangganId);
            if ($penjualanId) {
                $success = "Transaksi berhasil disimpan.";
            } else {
                $errors[] = "Gagal menyimpan transaksi.";
            }
        }
    }
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Transaksi Kasir</title>
</head>
<body>
    <h1>Transaksi Kasir</h1>



<?php if ($success): ?><p style="color:green;"> <?= htmlspecialchars($success) ?> </p><?php endif; ?>
<?php if ($errors): ?><ul style="color:red;"> <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?> </ul><?php endif; ?>



<!-- <form method="post">
<label>Tanggal: <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>"></label>
<label>Pelanggan:<select name="pelanggan_id">
  <option  value="">-- pilih --</option>
  <?php foreach ($pelanggan as $pl): ?>
    <option value="<?= $pl['PelangganID'] ?>"> <?= htmlspecialchars($pl['NamaPelanggan']) ?> </option>
  <?php endforeach; ?>
</select></label>
<br><br>
</form> -->


<form method="post">
<input type="hidden" name="action" value="add_item">
<label>Produk: <select name="produk_id">
<option disabled selected>-- pilih --</option>
<?php foreach ($produk as $p): ?>
<option value="<?= $p['ProdukID'] ?>"> <?= htmlspecialchars($p['NamaProduk']) ?> (Stok:<?= $p['Stok'] ?>)</option>
<?php endforeach; ?>
</select></label>
<label>Qty: <input type="number" name="qty" value="1"></label>
<button type="submit">Tambah</button>
</form>


<h3>Keranjang</h3>
<table border="1">
<tr>
    <th>NO.</th>
    <th>Produk</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Aksi</th>
</tr>
<?php if (!cart_items()): ?>
<tr><td colspan="6">Kosong</td></tr>
<?php else: foreach(cart_items() as $pid=>$row): ?>
<?php $i = 1; ?>
<tr>
<td><?= $i ?></td>
<input type="hidden" name="transaksi_id" value="<?= $pid ?>">
<td><?= htmlspecialchars($row['nama']) ?></td>
<td><?= $row['harga'] ?></td>
<td><?= $row['qty'] ?></td>
<td><?= $row['harga'] * $row['qty'] ?></td>
<td>
<form method="post" style="display:inline;">
<input type="hidden" name="action" value="remove_item">
<input type="hidden" name="produk_id" value="<?= $pid ?>">
<button type="submit">Hapus</button>
</form>
</td>
</tr>
<?php $i++; ?>
<?php endforeach; endif; ?>

<tr><th colspan="4">TOTAL</th><th colspan="2"> <?= cart_total() ?> </th></tr>
</table>


<form method="post">
  <input type="hidden" name="action" value="checkout">
  <label>Tanggal:
      <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>">
  </label>
  <label>Pelanggan:
      <select name="pelanggan_id" required>
          <option value="">-- pilih --</option>
          <?php foreach ($pelanggan as $pl): ?>
              <option value="<?= $pl['PelangganID'] ?>"> <?= htmlspecialchars($pl['NamaPelanggan']) ?> </option>
          <?php endforeach; ?>
      </select>
  </label>
  <br><br>
  <button type="submit" name="submit">Simpan Transaksi</button>
  <a href="login.php">Kembali</a>
  <a href="logot.php">Logout</a>
</form>
</body>
</html>