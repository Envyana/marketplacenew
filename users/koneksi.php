<?php
// Koneksi ke database
$host = 'localhost'; // Ganti dengan alamat host database Anda
$user = 'root';      // Ganti dengan username database Anda
$password = '';      // Ganti dengan password database Anda
$database = 'marketplace'; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengatur charset ke UTF-8 untuk memastikan penanganan karakter
mysqli_set_charset($conn, "utf8");

// Jika ingin menggunakan PDO, uncomment kode di bawah ini
/*
try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
*/
?>
