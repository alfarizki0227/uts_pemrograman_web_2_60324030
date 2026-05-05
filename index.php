<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            font-weight: 600;
            color: #0d6efd;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: 500;
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f7ff;
            transition: 0.2s;
        }

        .btn-primary {
            border-radius: 8px;
        }

        .btn-warning {
            border-radius: 6px;
        }

        .btn-danger {
            border-radius: 6px;
        }

        .badge {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

<?php
require_once 'config/database.php';
$query = "SELECT * FROM kategori ORDER BY id_kategori DESC";
$stmt  = $conn->prepare($query);

if (!$stmt) {
    die("Query error: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">📚 Daftar Kategori Buku</h2>
        <a href="create.php" class="btn btn-primary shadow-sm">
            + Tambah Kategori
        </a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success shadow-sm">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger shadow-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Kategori
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="text-center">
                    <tr>
                        <th width="50">No</th>
                        <th width="120">Kode</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th width="100">Status</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td>
                                    <span class="fw-semibold text-primary">
                                        <?= htmlspecialchars($row['kode_kategori']); ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                                <td>
                                    <?= $row['deskripsi'] 
                                        ? htmlspecialchars($row['deskripsi']) 
                                        : '<em class="text-muted">-</em>'; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] === 'Aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $row['id_kategori']; ?>" 
                                        class="btn btn-primary btn-sm">
                                        Edit
                                    </a>
                                    <button 
                                        class="btn btn-danger btn-sm"
                                        onclick="confirmDelete(<?= $row['id_kategori']; ?>)">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                📭 Data kategori belum tersedia.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus kategori ini?')) {
        window.location.href = 'delete.php?id=' + id;
    }
}
</script>
</body>
</html>