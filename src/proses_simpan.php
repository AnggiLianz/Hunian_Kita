<?php
include 'src/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama              = $_POST['nama'];
    $email             = $_POST['email'];
    $no_hp             = $_POST['no_hp'];
    $properti          = $_POST['properti'];
    $tanggal           = $_POST['tanggal'];
    $durasi            = $_POST['durasi'];
    $jumlah_properti   = $_POST['jumlah_tiket'];
    $total_sewa        = $_POST['total_sewa'];

    $sql = "INSERT INTO pemesanan (nama, email, no_hp, properti, tanggal, durasi, jumlah_properti, total_sewa)
            VALUES ('$nama', '$email', '$no_hp', '$properti', '$tanggal', '$durasi', '$jumlah_properti', '$total_sewa')";

    if ($koneksi->query($sql) === TRUE) {
        header("Location: src/halaman_history.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

$koneksi->close();
?>
