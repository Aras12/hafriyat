<?php
/**
 * Database Sınıfı - PDO Bağlantısı
 */
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
            die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            error_log("Query Error: " . $e->getMessage());
            return false;
        }
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : [];
    }

    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : null;
    }

    public function execute($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? true : false;
    }

    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    // Güvenli single değer getirme
    public function getSetting($key, $default = '') {
        $result = $this->fetchOne("SELECT setting_value FROM settings WHERE setting_key = ?", [$key]);
        return $result ? $result['setting_value'] : $default;
    }

    // Setting güncelleme
    public function updateSetting($key, $value) {
        $sql = "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE setting_value = ?";
        return $this->execute($sql, [$key, $value, $value]);
    }
}
