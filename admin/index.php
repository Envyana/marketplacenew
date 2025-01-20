<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Debug untuk melihat input user
    echo "Username: $username, Password: $password <br>";

    // Query untuk mencocokkan username dan password
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $login = mysqli_query($koneksi, $query);

    if (!$login) {
        die("Error pada query: " . mysqli_error($koneksi));
    }

    $r = mysqli_fetch_array($login);

    // Debug untuk melihat hasil query
    echo "Hasil Query: ";
    print_r($r);

    if (mysqli_num_rows($login) > 0) {
        session_start();
        $_SESSION['username'] = $r['username'];
        $_SESSION['nama'] = $r['nama'];
        header('location:utama.php?page=dashboard');
    } else {
        echo "<script>alert('Username atau Password salah!'); window.location.href='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Starpowers</title>
    <link rel="shortcut icon" type="image/x-icon" href="logo warna sp.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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
        }
        .header img {
            width: 150px;
            height: 40px;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .form-container {
            padding: 20px;
        }
        .form-container label {
            display: block;
            margin-top: 20px;
            font-size: 14px;
        }
        .form-container input {
            width: 94%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #cccccc;
            border-radius: 5px;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo putih sp full.png" alt="Starpowers logo">
            <h2>Dashboard Admin</h2>
        </div>
        <div class="form-container">
            <h3>Login Admin</h3>
            <form action="index.php" method="POST">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Masukkan username" required>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Masukkan password" required>
                <button type="submit" name="submit">LOGIN</button>
            </form>
            <div class="login-link">
                <a href="forgot_password.php">Lupa Password?</a>
            </div>
        </div>
    </div>
</body>
</html>
