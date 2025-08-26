
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

   // Jika $level adalah array, cek apakah level user ada di array
   if (is_array($level)) {
      if (!in_array($_SESSION["Level"], $level)) {
         if ($_SESSION["Level"] === "admin") {
            header("Location: admin.php");
         } else {
            header("Location: kasir.php");
         }
         exit;
      }
   } else {
      if ($_SESSION["Level"] !== $level) {
         if ($_SESSION["Level"] === "admin") {
            header("Location: admin.php");
         } else {
            header("Location: kasir.php");
         }
         exit;
      }
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

function tambahPelanggan($data) {
   global $conn;
   $nama = htmlspecialchars($data["Nama"]);
   $alamat = htmlspecialchars($data["Alamat"]);
   $nomer = htmlspecialchars($data["Nomer_Telepon"]);

   $query = "INSERT INTO pelanggan (NamaPelanggan, Alamat, NomerTelepon) VALUES ('$nama', '$alamat', '$nomer')";
   mysqli_query($conn, $query);

   return mysqli_affected_rows($conn);
}


function ubah($data) {
    global $conn;
    $id = $data["ID"];
    $nik = htmlspecialchars($data["NIK"]);
    $nama= htmlspecialchars ($data["Nama"]);
    $alamat= htmlspecialchars ($data["Alamat"]);
    $password= htmlspecialchars ($data["Password"]);
    $level= htmlspecialchars ($data["Level"]);

    $query = "UPDATE admin SET
              NIK = '$nik',
              Nama = '$nama',
              Alamat = '$alamat',
              Password = '$password',
              Level = '$level'
              WHERE ID = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function Produk($data) {
    global $conn;
    $nama = htmlspecialchars($data["Nama"]);
    $harga  = htmlspecialchars ($data["Harga"]);
    $stok = htmlspecialchars ($data["Stok"]);


    $query = "INSERT INTO produk (NamaProduk, Harga, Stok )
              VALUES ('$nama', '$harga', '$stok')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function Produk_ubah($data) {
    global $conn;
    $id = $data["ID"];
    $nama = htmlspecialchars($data["Nama"]);
    $harga  = htmlspecialchars ($data["Harga"]);
    $stok = htmlspecialchars ($data["Stok"]);


    $query = "UPDATE produk SET
              NamaProduk = '$nama',
              Harga = '$harga',
              Stok = '$stok'
              WHERE ProdukID = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus_produk($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM produk WHERE ProdukID = $id");
    return mysqli_affected_rows($conn);
}

function hapus_karyawan($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM admin WHERE ID = $id");
    return mysqli_affected_rows($conn);
}

if (!isset($_SESSION['cart'])) {
$_SESSION['cart'] = [];
}


function cart_add($produk_id, $nama, $harga, $qty) {
$qty = max(1, (int)$qty);
if (isset($_SESSION['cart'][$produk_id])) {
$_SESSION['cart'][$produk_id]['qty'] += $qty;
} else {
$_SESSION['cart'][$produk_id] = [
'nama' => $nama,
'harga' => (int)$harga,
'qty' => $qty,
];
}
}


function cart_update_qty($produk_id, $qty) {
if (isset($_SESSION['cart'][$produk_id])) {
$qty = (int)$qty;
if ($qty <= 0) {
unset($_SESSION['cart'][$produk_id]);
} else {
$_SESSION['cart'][$produk_id]['qty'] = $qty;
}
}
}


function cart_remove($produk_id) {
unset($_SESSION['cart'][$produk_id]);
}


function cart_clear() {
$_SESSION['cart'] = [];
}


function cart_items() {
return $_SESSION['cart'];
}


function cart_total() {
$total = 0;
foreach (cart_items() as $row) {
$total += $row['harga'] * $row['qty'];
}
return $total;
}


// Fungsi untuk menambah transaksi penjualan dan detailnya
function tambahTransaksi($pelangganID) {
   global $conn;
   $tanggal = date('Y-m-d');
   $cart = cart_items();
   $totalHarga = cart_total();

   // Simpan ke tabel penjualan
   $queryPenjualan = "INSERT INTO penjualan (TanggalPenjualan, TotalHarga, PelangganID) 
   VALUES ('$tanggal', '$totalHarga', '$pelangganID')";
   mysqli_query($conn, $queryPenjualan);
   $penjualanID = mysqli_insert_id($conn);

   // Simpan detail ke tabel detail_penjualan dan update stok
   foreach ($cart as $produkID => $item) {
      $nama = $conn->real_escape_string($item['nama']);
      $harga = (int)$item['harga'];
      $qty = (int)$item['qty'];
      $subtotal = $harga * $qty;
      $queryDetail = "INSERT INTO detail_penjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal) 
      VALUES ($penjualanID, $produkID, $qty, $subtotal)";
      mysqli_query($conn, $queryDetail);
      // Update stok produk
      mysqli_query($conn, "UPDATE produk SET Stok = Stok - $qty WHERE ProdukID = $produkID");
   }

   // Kosongkan keranjang
   cart_clear();

   return $penjualanID;
}