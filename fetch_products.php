<?php
/**
 * File: fetch_products.php
 * Mô tả: API endpoint để lấy dữ liệu sản phẩm theo phân trang
 * Method: GET
 * Parameters: 
 *   - page: Số trang hiện tại (mặc định: 1)
 *   - limit: Số sản phẩm mỗi trang (mặc định: 5)
 */

// Thiết lập header để trả về JSON
header('Content-Type: application/json');

// Import các file cần thiết
require_once 'config/database.php';
require_once 'includes/Product.php';
require_once 'includes/Pagination.php';

// Khởi tạo kết nối database
$database = new Database();
$db = $database->getConnection();

// Khởi tạo đối tượng Product
$product = new Product($db);

// Lấy tham số từ request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;

// Đảm bảo giá trị hợp lệ
$page = max(1, $page);
$limit = max(1, min(50, $limit));

// Lấy tổng số sản phẩm
$total_records = $product->getTotal();

// Khởi tạo đối tượng Pagination
$pagination = new Pagination($total_records, $limit, $page);

// Lấy danh sách sản phẩm theo phân trang
$stmt = $product->getProducts($pagination->getOffset(), $pagination->getLimit());
$products = [];

// Chuyển đổi dữ liệu thành mảng
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $products[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
        'price' => $row['price'],
        'created_at' => $row['created_at']
    ];
}

// Chuẩn bị dữ liệu trả về
$response = [
    'products' => $products,
    'pagination' => [
        'current_page' => $pagination->getCurrentPage(),
        'total_pages' => $pagination->getTotalPages(),
        'page_numbers' => $pagination->getPageNumbers(),
        'has_next' => $pagination->hasNextPage(),
        'has_previous' => $pagination->hasPreviousPage(),
        'total_records' => $total_records
    ]
];

// Trả về dữ liệu dạng JSON
echo json_encode($response);
?> 