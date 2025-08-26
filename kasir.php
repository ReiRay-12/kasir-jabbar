<?php
session_start();

require 'functions.php';
cekLogin("karyawan");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
</head>
<body>
    <h1>huh?</h1>
  <a href="logout.php">Logout</a>
  <a href="data_produk.php">Data Produk</a>
</body>
</html>