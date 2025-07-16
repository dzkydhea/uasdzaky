<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit;
}

$idUser = $_SESSION['idUser'];

if (isset($_POST['upload'])) {
    $namaFile = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $folder = "uploads/";

    if (move_uploaded_file($tmp, $folder . $namaFile)) {
        mysqli_query($koneksi, "INSERT INTO tbl_foto (idUser, foto) VALUES ('$idUser', '$namaFile')");
        $success = "Foto berhasil diupload.";
    } else {
        $error = "Upload gagal. Pastikan file benar.";
    }
}

$result = mysqli_query($koneksi, "SELECT foto FROM tbl_foto WHERE idUser = '$idUser' ORDER BY idFoto DESC LIMIT 1");
$dataFoto = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - Upload Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Edit Profil - Upload Foto</h3>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-light shadow-sm">
        <div class="mb-3">
            <label class="form-label">Pilih Foto Profil</label>
            <input type="file" name="foto" class="form-control" required>
        </div>
        <button type="submit" name="upload" class="btn btn-primary">Upload</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>

    <?php if ($dataFoto): ?>
        <div class="mt-4">
            <p>Foto Saat Ini:</p>
            <img src="uploads/<?= htmlspecialchars($dataFoto['foto']) ?>" alt="Foto Profil" class="img-thumbnail" width="200">
        </div>
    <?php endif; ?>
</div>
</body>
</html>