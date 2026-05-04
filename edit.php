<?php
require_once 'config/database.php';

// Ambil ID
$id = $_GET['id'] ?? 0;

if ($id == 0) {
    die("ID tidak valid");
}

// Ambil data lama
$stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Data tidak ditemukan");
}

$data = $result->fetch_assoc();

// Inisialisasi
$errors = [];
$kode = $data['kode_kategori'];
$nama = $data['nama_kategori'];
$deskripsi = $data['deskripsi'];
$status = $data['status'];

// Proses update
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

    // Cek duplikat (exclude diri sendiri)
    if (empty($errors)) {
        $stmt = $conn->prepare("
            SELECT id_kategori 
            FROM kategori 
            WHERE kode_kategori = ? AND id_kategori != ?
        ");
        $stmt->bind_param("si", $kode, $id);
        $stmt->execute();
        $cek = $stmt->get_result();

        if ($cek->num_rows > 0) {
            $errors[] = "Kode sudah digunakan";
        }
        $stmt->close();
    }

    // Update
    if (count($errors) == 0) {
        $stmt = $conn->prepare("
            UPDATE kategori 
            SET kode_kategori=?, nama_kategori=?, deskripsi=?, status=? 
            WHERE id_kategori=?
        ");

        $stmt->bind_param("ssssi", $kode, $nama, $deskripsi, $status, $id);

        if ($stmt->execute()) {
            header("Location: index.php?success=Data berhasil diupdate");
            exit;
        } else {
            $errors[] = "Gagal update data";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.1rem rgba(13,110,253,.25);
        }

        .btn-primary {
            border-radius: 8px;
        }

        .btn-secondary {
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-lg">

        <div class="card-header">
            <h4 class="mb-0">✏️ Edit Kategori</h4>
        </div>

        <div class="card-body">

            <!-- ERROR -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- FORM -->
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" name="kode" class="form-control"
                           value="<?= htmlspecialchars($kode) ?>" placeholder="KAT-001">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control"
                           value="<?= htmlspecialchars($nama) ?>" placeholder="Contoh: Pemrograman">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?= htmlspecialchars($deskripsi) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Aktif" <?= $status=="Aktif"?"selected":"" ?>>Aktif</option>
                        <option value="Nonaktif" <?= $status=="Nonaktif"?"selected":"" ?>>Nonaktif</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Update</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>