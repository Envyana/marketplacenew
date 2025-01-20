<?php 
include "koneksi.php";

if (isset($_POST['submit'])) {
    // Ambil input dari form
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password dengan MD5

    // Query menggunakan Prepared Statement
    $query = "SELECT * FROM seller WHERE username = ? AND password = ?";
    $stmt = $koneksi->prepare($query);

    if ($stmt) {
        // Bind parameter dan eksekusi
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Ambil data user
            $r = $result->fetch_assoc();

            // Mulai sesi dan simpan data penting ke sesi
            session_start();
            $_SESSION['id_penjual'] = $r['id_penjual']; // Simpan id_penjual
            $_SESSION['username'] = $r['username'];    // Simpan username
            $_SESSION['email'] = $r['email'];          // Simpan email
            $_SESSION['role'] = 'penjual';             // Simpan role

            // Redirect ke dashboard
            header('Location: utamapenjual.php?page=dashboard');
            exit;
        } else {
            // Jika login gagal
            echo "<script>alert('Username atau Password salah!'); window.location.href='indexpenjual.php';</script>";
        }
    } else {
        // Debug jika query gagal
        die("Query gagal: " . $koneksi->error);
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Gaya CSS */
        body {
            font-family: 'Poppins';
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
            <a href="indexpenjual.php"><img alt="Logo Starpowers" src="logo putih sp full.png"></a>
            <h2>Dashboard Penjual</h2>
        </div>
        <div class="form-container">
            <h3>Login Sebagai Penjual</h3>
            <form method="post" action="indexpenjual.php">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Masukkan username" required>
                
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Masukkan password" required>
                
                <div class="password-info">Panjang password minimal 6 karakter</div>
                
                <button type="submit" name="submit">LOGIN</button>
            </form>
            <div class="login-link">
                Belum punya akun? <a href="registerpenjual.php">Daftar di sini</a>
                <br>
                <a href="forgot_passwordpenjual.php">Lupa Password?</a>
            </div>
        </div>
    </div>
</body>
</html>
