<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, md5($_POST['password'])); // Hash password dengan MD5
    $toko = mysqli_real_escape_string($koneksi, $_POST['toko']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Periksa apakah username sudah terdaftar
    $cek_user = mysqli_query($koneksi, "SELECT * FROM seller WHERE username='$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location.href='registerpenjual.php';</script>";
    } else {
        // Insert data ke tabel seller
        $query = "INSERT INTO seller (username, email, password, toko) VALUES ('$username', '$email', '$password', '$toko')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='indexpenjual.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal! Coba lagi.'); window.location.href='registerpenjual.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Starpowers</title>
    <link rel="shortcut icon" type="image/x-icon" href="logo warna sp.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #001D3D;
            color: #ffffff;
            padding: 20px;
            text-align: left;
            position: relative;
        }
        .header img {
            width: 150px;
            height: 40px;
            display: block;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-align: left;
        }
        .form-container {
            padding: 20px;
        }
        .form-container a {
            color: #0a1931;
            text-decoration: none;
            font-size: 14px;
        }
        .form-container h3 {
            margin-top: 10px;
            font-size: 20px;
            color: #0a1931;
        }
        .form-container label {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: #333333;
        }
        .form-container input {
            width: 94%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #ffcc00;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }
        .form-container .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666666;
        }
        .form-container .login-link a {
            color: #0a1931;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="index.php"><img alt="Starpowers logo" src="logo putih sp full.png"></a>
            <h2>Dashboard Penjual</h2>
        </div>
        <div class="form-container">
            <a href="indexpenjual.php">&lt; Kembali</a>
            <h3>Register Sebagai Penjual</h3>
            <form action="registerpenjual.php" method="POST">
                <label for="toko">Nama Toko</label>
                <input id="toko" type="text" name="toko" placeholder="Masukkan nama Toko Anda" required>
                
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Masukkan email" required>
                
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Masukkan username" required>
                
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Masukkan password" required>
                
                <button type="submit" name="submit">Daftar</button>
            </form>
            <div class="login-link">
                Sudah punya akun? <a href="indexpenjual.php">Login di sini</a>
            </div>
        </div>
    </div>
</body>
</html>

