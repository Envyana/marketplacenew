<?php
session_start();
include('koneksi.php'); // Include koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $NoHP = mysqli_real_escape_string($conn, $_POST['NoHP']);
    // Tidak perlu menentukan role, karena sudah otomatis jadi 'user'

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email sudah digunakan
    $checkEmailQuery = "SELECT * FROM users WHERE email=?";
    $stmtCheck = $conn->prepare($checkEmailQuery);
    if ($stmtCheck === false) {
        die('Query preparation failed: ' . $conn->error); // Menangani error jika prepare gagal
    }
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $checkResult = $stmtCheck->get_result();

    if ($checkResult->num_rows > 0) {
        $error = "Email sudah terdaftar. Gunakan email lain.";
    } else {
        // Query untuk menyimpan user baru tanpa kolom 'role'
        $query = "INSERT INTO users (username, email, password, alamat, NoHP) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Query preparation failed: ' . $conn->error); // Menangani error jika prepare gagal
        }
        
        // Hanya 5 parameter karena ada 5 placeholder ?
        $stmt->bind_param("sssss", $name, $email, $hashedPassword, $alamat, $NoHP);

        if ($stmt->execute()) {
            // Registrasi berhasil, arahkan ke halaman login
            header("Location: login.php");
            exit;
        } else {
            $error = "Gagal mendaftar. Coba lagi.";
        }

        $stmt->close();
    }

    $stmtCheck->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starpowers Marketplace</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/logo/logo warna sp.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        html, body {
            overflow-y: auto;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto; /* Allow space for scrolling */
            overflow: hidden;
        }

        .header {
            background-color: #001D3D;
            color: #ffffff;
            padding: 20px;
            text-align: left;
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

        .form-container input,
        .form-container textarea {
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
            <a href="index_user.php">
                <img alt="Starpowers logo" src="assets/logo/logo putih sp full.png">
            </a>
            <h2>Dashboard Pembeli</h2>
        </div>
        <div class="form-container">
            <a href="login.php">&lt; Kembali</a>
            <h3>Daftar Sebagai Pembeli</h3>
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="name">Nama</label>
                <input id="name" name="name" type="text" placeholder="Nama Lengkap Anda" required>
                
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="email@contoh.com" required>
                
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Minimal 6 karakter" required>
                
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap Anda" required></textarea>
                
                <label for="NoHP">No HP</label>
                <input id="NoHP" name="NoHP" type="text" placeholder="Nomor HP aktif Anda" required>
                
                <button type="submit">DAFTAR</button>
            </form>
            <div class="login-link">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </div>
</body>
</html>




