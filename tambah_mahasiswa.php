<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nim     = $_POST['nim'];
    $nama    = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat  = $_POST['alamat'];

    $query1 = mysqli_query($koneksi, "INSERT INTO tbl_mahasiswa (nim, nama, jurusan, alamat) 
        VALUES ('$nim', '$nama', '$jurusan', '$alamat')");

    if ($query1) {
        $idMhs = mysqli_insert_id($koneksi);
        $username = $nim;
        $password = password_hash($nim, PASSWORD_DEFAULT);

        $query2 = mysqli_query($koneksi, "INSERT INTO tbl_user (username, password, idMhs) 
            VALUES ('$username', '$password', '$idMhs')");

        $success = $query2 ? "Data mahasiswa dan user berhasil ditambahkan." : "Gagal menambahkan user.";
    } else {
        $error = "Gagal menambahkan data mahasiswa.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Tambah Data Mahasiswa</h3>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="border p-4 rounded shadow-sm bg-light">
        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <input type="text" name="jurusan" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>