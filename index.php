<?php
/**
 * File: index.php
 * Mô tả: File chính của ứng dụng, hiển thị giao diện danh sách sản phẩm với phân trang
 */

// Kết nối database và khởi tạo đối tượng Product
require_once 'config/database.php';
require_once 'includes/Product.php';

// Khởi tạo kết nối database
$database = new Database();
$db = $database->getConnection();

// Khởi tạo đối tượng Product để tương tác với bảng products
$product = new Product($db);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <!-- Liên kết file CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* CSS cho phần nhập số lượng sản phẩm */
        .per-page-input {
            width: 60px;
            padding: 5px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        /* CSS cho thông báo lỗi */
        .error-message {
            color: red;
            display: none;
            margin-top: 5px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Danh sách sản phẩm</h1>
        
        <!-- Phần điều khiển số lượng sản phẩm hiển thị -->
        <div class="per-page-select">
            <div class="per-page-controls">
                <label for="customPerPage">Số sản phẩm mỗi trang:</label>
                <input type="number" id="customPerPage" class="per-page-input" min="1" placeholder="Nhập số sản phẩm">
                <button id="applyCustomPerPage">Áp dụng</button>
                <div id="errorMessage" class="error-message">Vui lòng nhập số từ 1 đến n (n là tổng số sản phẩm)</div>
            </div>
            <div class="product-info">
                <span>Tổng số sản phẩm: <strong id="totalProducts">0</strong></span>
            </div>
        </div>

        <!-- Phần hiển thị loading -->
        <div class="loading"></div>
        
        <!-- Phần hiển thị danh sách sản phẩm -->
        <div class="product-list"></div>
        
        <!-- Phần điều hướng phân trang -->
        <div class="pagination-container">
            <div class="pagination-info">
                <span>Trang <strong id="currentPage">1</strong> / <strong id="totalPages">1</strong></span>
            </div>
            <div class="pagination"></div>
        </div>
    </div>

    <!-- Liên kết file JavaScript -->
    <script src="js/pagination.js"></script>
</body>
</html> 