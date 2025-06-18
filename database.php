<?php
class Database {
    public function getConnection() {
        $host = '127.0.0.1';
        $dbname = 'login_db';
        $username = 'root';
        $password = 'Dmtn_2004'; // Để trống nếu dùng Laragon
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            return new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            file_put_contents("debug.log", "❌ Lỗi kết nối CSDL: " . $e->getMessage() . "\n", FILE_APPEND);
            die("Lỗi kết nối CSDL!");
        }
    }
}

