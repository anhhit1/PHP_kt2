<?php
/**
 * File: config/database.php
 * Mô tả: Lớp Database để kết nối và tương tác với MySQL database
 * Cung cấp phương thức để thiết lập kết nối PDO
 */

/**
 * Lớp Database
 * Quản lý kết nối đến MySQL database
 */
class Database {
    /**
     * Tên máy chủ database
     * @var string
     */
    private $host = "localhost";
    
    /**
     * Tên database
     * @var string
     */
    private $db_name = "pagination_db";
    
    /**
     * Tên người dùng database
     * @var string
     */
    private $username = "root";
    
    /**
     * Mật khẩu database
     * @var string
     */
    private $password = "";
    
    /**
     * Kết nối PDO
     * @var PDO
     */
    public $conn;

    /**
     * Thiết lập kết nối PDO đến database
     * @return PDO Kết nối PDO
     */
    public function getConnection() {
        $this->conn = null;

        try {
            // Tạo kết nối PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            
            // Thiết lập chế độ lỗi
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Thiết lập bảng mã ký tự UTF-8
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            // Xử lý lỗi kết nối
            echo "Lỗi kết nối: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?> 