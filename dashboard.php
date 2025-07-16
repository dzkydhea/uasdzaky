<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit;
}

$idUser = $_SESSION['idUser'];

$query = mysqli_query($koneksi, "
    SELECT u.username, m.nama, m.nim, m.jurusan, m.alamat
    FROM tbl_user u
    LEFT JOIN tbl_mahasiswa m ON u.idMhs = m.idMhs
    WHERE u.idUser = '$idUser'
");
$user = mysqli_fetch_assoc($query);

$fotoQuery = mysqli_query($koneksi, "
    SELECT foto FROM tbl_foto
    WHERE idUser = '$idUser'
    ORDER BY idFoto DESC LIMIT 1
");
$fotoData = mysqli_fetch_assoc($fotoQuery);
$foto = $fotoData ? $fotoData['foto'] : 'default.png';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="uploads/<?= htmlspecialchars($foto) ?>" class="img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <a href="editprofile.php" class="btn btn-sm btn-outline-primary w-100">Ganti Foto</a>
            </div>
            <div class="col-md-9">
                <h4>Selamat Datang, <?= htmlspecialchars($user['nama']) ?></h4>
                <table class="table table-bordered mt-3">
                    <tr><th>NIM</th><td><?= htmlspecialchars($user['nim']) ?></td></tr>
                    <tr><th>Jurusan</th><td><?= htmlspecialchars($user['jurusan']) ?></td></tr>
                    <tr><th>Alamat</th><td><?= htmlspecialchars($user['alamat']) ?></td></tr>
                </table>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>