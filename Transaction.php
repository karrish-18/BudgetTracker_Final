<?php
class Transaction {
    private $db;
    public function __construct($db_conn) { $this->db = $db_conn; }

    public function add($user_id, $amount, $desc) {
        $sql = "INSERT INTO transactions (user_id, amount, description, date) VALUES (?, ?, ?, CURDATE())";
        return $this->db->prepare($sql)->execute([$user_id, $amount, $desc]);
    }

    public function getHistory($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBalance($user_id) {
        $stmt = $this->db->prepare("SELECT SUM(amount) as total FROM transactions WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }
}
?>