<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_mahasiswa_web");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>