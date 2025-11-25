<?php
$start = microtime(true);

$host = '127.0.0.1'; // Kita paksa IP
$db   = 'hmif';
$user = 'root';
$pass = '23ni'; // Sesuaikan jika ada password
$port = 3306;

try {
    $dsn = "mysql:host=$host;dbname=$db;port=$port";
    $pdo = new PDO($dsn, $user, $pass);
    echo "Koneksi Database SUKSES! <br>";
} catch (\PDOException $e) {
    echo "Koneksi Database GAGAL: " . $e->getMessage() . "<br>";
}

echo "Total Time: " . ((microtime(true) - $start) * 1000) . " ms";
?>