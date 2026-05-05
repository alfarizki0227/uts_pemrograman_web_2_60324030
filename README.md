Nama: Alfarizki Febri Mardipurlani<br>
NIM: 60324030<br>
Aplikasi ini merupakan sistem manajemen kategori buku berbasis web yang dibuat menggunakan PHP Native dan MySQL. Aplikasi ini digunakan untuk mengelola data kategori buku di perpustakaan dengan fitur CRUD (Create, Read, Update, Delete).<br>
Fitur:
<ol>
<li>Menampilkan data kategori buku</li>
<li>Menambahkan kategori buku</li>
<li>Mengedit kategori buku</li>
<li>Menghaspus kategori buku</li>
<li>Validasi peng-inputan data</li>
</ol>
Cara instalasi & menjalankan program:
<ol>
   <li>Install XAMP/Laragon</li>
   <li>Jalankan Apache & MySQL</li>
   <li>Copy project dan letakkan di C:\XAMP\htdocs</li>
   <li>buat database dengan nama "uts_perpustakaan_60324030"</li>
   <li>import file "database_backup.sql" atau lakukan:<br>
   - membuat table dengan cara: CREATE TABLE kategori (
     id_kategori INT AUTO_INCREMENT PRIMARY KEY,
     kode_kategori VARCHAR(10) UNIQUE NOT NULL,
     nama_kategori VARCHAR(50) NOT NULL,
     deskripsi TEXT,
     status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );<br>
   - lalu insert data dengan cara: INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi, status) VALUES
     ('KAT-001', 'Pemrograman', 'Buku-buku tentang bahasa pemrograman', 'Aktif'),
     ('KAT-002', 'Database', 'Buku-buku tentang sistem basis data', 'Aktif'),
     ('KAT-003', 'Jaringan', 'Buku-buku tentang jaringan komputer', 'Aktif');</li>
   <li>Jalankan aplikasi di browser dengan cara memasukkan url: "http://localhost/uts_60324030/index.php"</li>
</ol>
7. Struktur folder: uts_60324030 ├── config/ │ └── database.php ├── index.php ├──create.php ├── edit.php ├── delete.php
Link https://github.com/alfarizki0227/uts_pemrograman_web_2_60324030
