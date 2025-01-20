<?php
include('koneksi.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    die('Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_selection'])) {
    $id_keranjang = intval($_POST['toggle_selection']);
    $is_selected = isset($_POST['is_selected']) ? intval($_POST['is_selected']) : 0;
    
    $update_stmt = $conn->prepare("UPDATE cart SET is_selected = ? WHERE id_keranjang = ?");
    $update_stmt->bind_param("ii", $is_selected, $id_keranjang);
    
    if ($update_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
