<?php
session_start();
$_SESSION['user'] = 'admin';
echo "Login berhasil sebagai admin.<br>";
echo "<a href='transfer.php'>Masuk ke halaman transfer</a>";
?>
