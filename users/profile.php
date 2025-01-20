<?php

include('koneksi.php');

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Mengambil data pengguna berdasarkan username
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Menangani update profil jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $NoHP = $_POST['NoHP'];
    $profile_image = $user['profile_image'];

    // Mengunggah gambar baru jika ada
    if ($_FILES['profile_image']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_image']['name']);
        
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $profile_image = basename($_FILES['profile_image']['name']);
        }
    }

    // Update data pengguna
    $update_sql = "UPDATE users SET username = ?, email = ?, alamat = ?, NoHP = ?, profile_image = ?, updated = NOW() WHERE username = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssss", $new_username, $email, $alamat, $NoHP, $profile_image, $username);
    $update_stmt->execute();

    // Update session username jika diubah
    $_SESSION['username'] = $new_username;

    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
</head>
<body>
    <h1 style="text-align: center;">Profil Pengguna</h1>
    <div style="width: 80%; margin: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Gambar Profil -->
                <td style="width: 30%; text-align: center; vertical-align: top;">
                    <img src="uploads/default.png" alt="Profile Image" width="150" height="150" style="border-radius: 50%; object-fit: cover;">
                    <br>
                    <label for="profile_image">Ubah Gambar Profil</label>
                    <form method="POST" action="upload.php" enctype="multipart/form-data">
                        <input type="file" id="profile_image" name="profile_image">
                        <br><br>
                        <button type="submit">Unggah</button>
                    </form>
                </td>

                <!-- Form Profil -->
                <td style="width: 70%; vertical-align: top;">
                    <form method="POST" action="profile.php">
                        <table style="width: 100%; border-spacing: 10px;">
                            <tr>
                                <td><label for="username">Username</label></td>
                                <td><input type="text" id="username" name="username" value="JohnDoe" required style="width: 100%;"></td>
                            </tr>
                            <tr>
                                <td><label for="email">Email</label></td>
                                <td><input type="email" id="email" name="email" value="johndoe@example.com" required style="width: 100%;"></td>
                            </tr>
                            <tr>
                                <td><label for="alamat">Alamat</label></td>
                                <td><textarea id="alamat" name="alamat" rows="3" style="width: 100%;">Jl. Contoh Alamat</textarea></td>
                            </tr>
                            <tr>
                                <td><label for="NoHP">No HP</label></td>
                                <td><input type="text" id="NoHP" name="NoHP" value="081234567890" style="width: 100%;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <button type="submit" style="padding: 10px 20px;">Perbarui Profil</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
