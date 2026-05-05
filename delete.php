<?php
require_once 'config/database.php';

// Ambil ID
$id = $_GET['id'] ?? 0;

if ($id == 0) {
    header("Location: index.php?error=ID tidak valid");
    exit;
}

// Cek data
$stmt = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php?error=Data tidak ditemukan");
    exit;
}
$stmt->close();

// Delete
$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?success=Data berhasil dihapus");
} else {
    header("Location: index.php?error=Gagal menghapus data");
}

$stmt->close();
closeConnection();
?>