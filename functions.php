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

function tambah($data) {
    global $conn;
    $nik = htmlspecialchars($data["NIK"]);
    $nama= htmlspecialchars ($data["Nama"]);
    $alamat= htmlspecialchars ($data["Alamat"]);
    $password= htmlspecialchars ($data["Password"]);
    $level= htmlspecialchars ($data["Level"]);
 
    // $foto= upload();
    // if(!$foto){
    //     return false;
    // }
    // $password = mysqli_real_escape_string($conn, $data["password"]);
    // $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    // $level = $data["level"];
    
    // if( $password !== $password2){
    //     echo "<script>
    //                 alert('konfirmasi password tidak sesuai!');
    //           </script>";
    //           return false;
    // }

    // //enkripsi
    // $password = password_hash($password,PASSWORD_DEFAULT);
    

    $query = "INSERT INTO admin (NIK, Nama, Alamat, Password, Level) 
              VALUES 
              ('$nik', '$nama', '$alamat', '$password', '$level')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
