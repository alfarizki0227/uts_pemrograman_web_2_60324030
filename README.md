Nama: Alfarizki Febri Mardipurlani
NIM: 60324030
Aplikasi ini merupakan sistem manajemen kategori buku berbasis web yang dibuat menggunakan PHP Native dan MySQL. Aplikasi ini digunakan untuk mengelola data kategori buku di perpustakaan dengan fitur CRUD (Create, Read, Update, Delete).
Fitur:
1. Menampilkan data kategori buku
2. Menambahkan kategori buku
3. Mengedit kategori buku
4. Menghaspus kategori buku
5. Validasi peng-inputan data
Cara instalasi & menjalankan program:
1. Install XAMP/Laragon
2. Jalankan Apache & MySQL
3. Copy project dan letakkan di C:\XAMP\htdocs
4. buat database dengan nama "uts_perpustakaan_60324030"
5. import file "database_backup.sql" atau lakukan:
   - membuat table dengan cara: CREATE TABLE kategori (
     id_kategori INT AUTO_INCREMENT PRIMARY KEY,
     kode_kategori VARCHAR(10) UNIQUE NOT NULL,
     nama_kategori VARCHAR(50) NOT NULL,
     deskripsi TEXT,
     status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );
   - lalu insert data dengan cara: INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi, status) VALUES
     ('KAT-001', 'Pemrograman', 'Buku-buku tentang bahasa pemrograman', 'Aktif'),
     ('KAT-002', 'Database', 'Buku-buku tentang sistem basis data', 'Aktif'),
     ('KAT-003', 'Jaringan', 'Buku-buku tentang jaringan komputer', 'Aktif');
6. Jalankan aplikasi di browser dengan cara memasukkan url: "http://localhost/uts_60324030/index.php"
7. Struktur folder: uts_60324030 ├── config/ │ └── database.php ├── index.php ├──create.php ├── edit.php ├── delete.php
