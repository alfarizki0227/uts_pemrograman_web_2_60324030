<?php
require_once 'config/database.php';

// Inisialisasi
$errors = [];
$kode = "";
$nama = "";
$deskripsi = "";
$status = "Aktif";

// Proses submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $kode      = sanitize($_POST['kode']);
    $nama      = sanitize($_POST['nama']);
    $deskripsi = sanitize($_POST['deskripsi']);
    $status    = $_POST['status'];

    // Validasi
    if (empty($kode)) {
        $errors[] = "Kode kategori wajib diisi";
    }

    if (empty($nama)) {
        $errors[] = "Nama kategori wajib diisi";
    }

    // Cek duplikat
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ?");
        $stmt->bind_param("s", $kode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Kode sudah digunakan";
        }
        $stmt->close();
    }

    // Insert
    if (count($errors) == 0) {
        $stmt = $conn->prepare("
            INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi, status)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("ssss", $kode, $nama, $deskripsi, $status);

        if ($stmt->execute()) {
            header("Location: index.php?success=Data berhasil ditambahkan");
            exit;
        } else {
            $errors[] = "Gagal menyimpan data";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Kategori</h4>
        </div>

        <div class="card-body">

            <!-- ERROR -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= $e ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" name="kode" class="form-control"
                           value="<?= $kode ?>" placeholder="KAT-001">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control"
                           value="<?= $nama ?>" placeholder="Contoh: Pemrograman">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?= $deskripsi ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Aktif" <?= $status=="Aktif"?"selected":"" ?>>Aktif</option>
                        <option value="Nonaktif" <?= $status=="Nonaktif"?"selected":"" ?>>Nonaktif</option>
                    </select>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>