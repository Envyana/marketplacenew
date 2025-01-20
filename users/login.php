<?php
session_start();
include('koneksi.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $error = '';

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan Password wajib diisi.";
    } else {
        // Query untuk memeriksa username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location:index_user.php');
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
            
        }
    }
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
        /* Gaya umum untuk tampilan modern */
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
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 94%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-container .password-info {
            font-size: 12px;
            color: #666666;
            margin-top: 5px;
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
        .form-container button:hover {
            background-color: #e6b800;
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
            <a href="index_user.php"><img alt="Starpowers logo" src="assets/logo/logo putih sp full.png"></a>
            <h2>Dashboard Pembeli</h2>
        </div>
        <div class="form-container">
            <a href="index_user.php">&lt; Kembali</a>
            <h3>Login Sebagai Pembeli</h3>
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Masukkan username Anda" required>
                
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Masukkan password Anda" required>
                <div class="password-info">Panjang password minimal 6 karakter</div>
                
                <button type="submit">LOGIN</button>
            </form>
            <div class="login-link">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
                <br>
                <a href="forgot_password.php">Lupa Password?</a>
            </div>
        </div>
    </div>
</body>
</html>

