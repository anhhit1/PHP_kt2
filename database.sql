/**
 * File: database.sql
 * Mô tả: Script SQL để tạo cấu trúc database và dữ liệu mẫu
 * Sử dụng để khởi tạo database cho ứng dụng hiển thị danh sách sản phẩm
 */

-- Tạo database pagination_db nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS pagination_db;
USE pagination_db;

-- Tạo bảng products để lưu trữ thông tin sản phẩm
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- ID tự động tăng, khóa chính
    name VARCHAR(255) NOT NULL,         -- Tên sản phẩm, không được để trống
    description TEXT,                   -- Mô tả sản phẩm
    price DECIMAL(10,2),                -- Giá sản phẩm, 10 chữ số với 2 chữ số thập phân
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Thời gian tạo, tự động cập nhật
);

-- Thêm dữ liệu mẫu vào bảng products
INSERT INTO products (name, description, price) VALUES
('iPhone 13', 'Điện thoại Apple mới nhất', 999.99),
('Samsung Galaxy S21', 'Flagship Android', 899.99),
('MacBook Pro', 'Laptop chuyên nghiệp', 1299.99),
('iPad Air', 'Máy tính bảng', 599.99),
('AirPods Pro', 'Tai nghe không dây', 249.99),
('Apple Watch', 'Đồng hồ thông minh', 399.99),
('Dell XPS 13', 'Laptop cao cấp', 1199.99),
('Sony WH-1000XM4', 'Tai nghe chống ồn', 349.99),
('Nintendo Switch', 'Máy chơi game', 299.99),
('Canon EOS R5', 'Máy ảnh mirrorless', 3899.99),
('LG OLED TV', 'TV 4K 65 inch', 1999.99),
('Bose 700', 'Tai nghe cao cấp', 379.99),
('DJI Mavic Air 2', 'Flycam', 799.99),
('GoPro Hero 9', 'Camera hành động', 449.99),
('Kindle Paperwhite', 'Máy đọc sách', 139.99); 


INSERT INTO products (name, description, price) VALUES
('Sony PlayStation 5', 'Máy chơi game thế hệ mới từ Sony', 499.99),
('Samsung Galaxy Watch 5', 'Đồng hồ thông minh cao cấp', 279.99);