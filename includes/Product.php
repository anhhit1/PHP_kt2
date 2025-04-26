<?php
/**
 * File: includes/Product.php
 * Mô tả: Lớp Product để tương tác với bảng products trong database
 * Cung cấp các phương thức để lấy thông tin sản phẩm
 */

/**
 * Lớp Product
 * Quản lý các thao tác liên quan đến sản phẩm trong database
 */
class Product {
    /**
     * Kết nối database
     * @var PDO
     */
    private $conn;
    
    /**
     * Tên bảng sản phẩm
     * @var string
     */
    private $table_name = "products";

    /**
     * Constructor
     * @param PDO $db Kết nối database
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lấy tổng số sản phẩm trong database
     * @return int Tổng số sản phẩm
     */
    public function getTotal() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    /**
     * Lấy danh sách sản phẩm theo phân trang
     * @param int $start Vị trí bắt đầu lấy dữ liệu
     * @param int $limit Số lượng sản phẩm cần lấy
     * @return PDOStatement Kết quả truy vấn
     */
    public function getProducts($start, $limit) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 ORDER BY id DESC 
                 LIMIT :start, :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":start", $start, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}
?> 