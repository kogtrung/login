<?php
class UserModel {
    private $db;
    public function __construct(PDO $conn) {
        $this->db = $conn;
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
