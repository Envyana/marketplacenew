<?php
// Memuat autoloader Composer
require '../vendor/autoload.php'; 

// Coba membuat instance dari PHPMailer
try {
    $mail = new \PHPMailer\PHPMailer\PHPMailer();
    echo 'PHPMailer class found and autoloaded successfully!';
} catch (Exception $e) {
    echo 'PHPMailer class not found: ' . $e->getMessage();
}
?>
