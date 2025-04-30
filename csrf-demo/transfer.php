<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "Silakan login terlebih dahulu.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST['to'];
    $amount = $_POST['amount'];
    echo "<h3>Transfer berhasil ke <b>$to</b> sejumlah <b>Rp $amount</b></h3>";
}
?>

<h2>Halaman Transfer Dana</h2>
<form method="POST" action="transfer.php">
    Tujuan: <input type="text" name="to"><br><br>
    Jumlah: <input type="text" name="amount"><br><br>
    <input type="submit" value="Transfer">
</form>
