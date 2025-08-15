<?php
// Koneksi ke databsae
$conn = mysqli_connect("localhost", "root", "", "data_penjualan");

// Global Query
function query($query)
{
    global $conn;

    //buka lemari
    $result = mysqli_query($conn, $query);
    $rows = [];

    //mengambil baju
    while ($row = mysqli_fetch_assoc($result)) {

        //$row baju yang belum di masukan ke dalam otak
        //$rows berisi baju yang di rapihkan dari row
        $rows[] = $row;
    }
    return $rows;
}

function cekLogin($level)
{
   if (!isset($_SESSION["login"])) {
      header("Location: login.php");
      exit;
   }

   if ($_SESSION["Level"] !== $level) {
      // Jika level tidak sesuai, arahkan ke halaman yang sesuai
      if ($_SESSION["Level"] === "admin") {
         header("Location: admin.php");
      } else {
         header("Location: kasir.php");
      }
      exit;
   }
}