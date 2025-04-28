/**
 * File: pagination.js
 * Mô tả: Xử lý phân trang và tải dữ liệu sản phẩm bằng AJAX
 */

document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các biến cần thiết
    let currentPage = 1;          // Trang hiện tại
    let recordsPerPage = 5;       // Số sản phẩm mỗi trang
    let totalProducts = 0;        // Tổng số sản phẩm

    // Tải sản phẩm lần đầu khi trang được load
    loadProducts(currentPage, recordsPerPage);

    // Xử lý sự kiện click nút Áp dụng
    document.getElementById('applyCustomPerPage').addEventListener('click', function() {
        applyCustomPerPage();
    });

    // Xử lý sự kiện nhấn Enter trên input
    document.getElementById('customPerPage').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyCustomPerPage();
        }
    });

    // Xử lý sự kiện click các nút phân trang
    document.addEventListener('click', function(e) {
        if (e.target.matches('.pagination button:not([disabled])')) {
            const page = e.target.dataset.page;
            if (page) {
                currentPage = parseInt(page);
                loadProducts(currentPage, recordsPerPage);
                // Cuộn lên đầu danh sách sản phẩm
                document.querySelector('.product-list').scrollIntoView({ 
                    behavior: 'smooth' 
                });
            }
        }
    });

    /**
     * Hàm xử lý áp dụng số sản phẩm tùy chỉnh
     * Kiểm tra và áp dụng số lượng sản phẩm mới cho mỗi trang
     */
    function applyCustomPerPage() {
        const customInput = document.getElementById('customPerPage');
        const errorMessage = document.getElementById('errorMessage');
        const value = parseInt(customInput.value);

        // Kiểm tra giá trị nhập vào
        if (isNaN(value) || value < 1) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Vui lòng nhập số lớn hơn 0';
            return;
        }

        // Kiểm tra giới hạn tổng số sản phẩm
        if (totalProducts > 0 && value > totalProducts) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = `Vui lòng nhập số từ 1 đến ${totalProducts}`;
            return;
        }

        // Áp dụng số lượng sản phẩm mới
        recordsPerPage = value;
        currentPage = 1;
        loadProducts(currentPage, recordsPerPage);
        errorMessage.style.display = 'none';
    }
});

/**
 * Hàm tải dữ liệu sản phẩm từ server bằng AJAX
 * @param {number} page - Số trang hiện tại
 * @param {number} limit - Số sản phẩm mỗi trang
 */
function loadProducts(page, limit) {
    const loading = document.querySelector('.loading');
    const productList = document.querySelector('.product-list');
    const customInput = document.getElementById('customPerPage');
    
    // Hiển thị trạng thái loading
    loading.style.display = 'block';
    productList.style.opacity = '0.5';

    // Gửi request AJAX đến server
    fetch(`fetch_products.php?page=${page}&limit=${limit}`)
        .then(response => response.json())
        .then(data => {
            productList.innerHTML = '';
            
            // Cập nhật thông tin tổng số sản phẩm và input
            window.totalProducts = data.pagination.total_records;
            customInput.value = limit;
            customInput.max = totalProducts;
            customInput.placeholder = `Nhập số từ 1 đến ${totalProducts}`;
            
            // Cập nhật hiển thị tổng số sản phẩm
            document.getElementById('totalProducts').textContent = totalProducts.toLocaleString('vi-VN');
            
            // Cập nhật hiển thị trang hiện tại và tổng số trang
            document.getElementById('currentPage').textContent = data.pagination.current_page.toLocaleString('vi-VN');
            document.getElementById('totalPages').textContent = data.pagination.total_pages.toLocaleString('vi-VN');
            
            // Hiển thị danh sách sản phẩm
            if (data.products.length === 0) {
                productList.innerHTML = '<p class="no-products">Không có sản phẩm nào.</p>';
            } else {
                data.products.forEach(product => {
                    const productHtml = `
                        <div class="product-item">
                            <h3>${product.name}</h3>
                            <p>${product.description}</p>
                            <div class="price">${new Intl.NumberFormat('vi-VN', { 
                                style: 'currency', 
                                currency: 'VND'
                            }).format(product.price * 23000)}</div>
                        </div>
                    `;
                    productList.innerHTML += productHtml;
                });
            }

            // Cập nhật giao diện phân trang
            updatePagination(data.pagination);
            
            // Ẩn trạng thái loading
            loading.style.display = 'none';
            productList.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error:', error);
            loading.style.display = 'none';
            productList.style.opacity = '1';
            productList.innerHTML = '<p class="error">Đã xảy ra lỗi khi tải dữ liệu.</p>';
        });
}

/**
 * Hàm cập nhật giao diện phân trang
 * @param {Object} pagination - Thông tin phân trang từ server
 */
function updatePagination(pagination) {
    const paginationContainer = document.querySelector('.pagination');
    let html = '';

    // Thêm nút Trang trước
    html += `
        <button ${pagination.current_page === 1 ? 'disabled' : ''} 
                data-page="${pagination.current_page - 1}">
            Trang trước
        </button>
    `;

    // Thêm các nút số trang
    pagination.page_numbers.forEach(page => {
        if (page === '...') {
            html += '<span>...</span>';
        } else {
            html += `
                <button ${pagination.current_page === page ? 'class="active"' : ''} 
                        data-page="${page}">
                    ${page}
                </button>
            `;
        }
    });

    // Thêm nút Trang sau
    html += `
        <button ${pagination.current_page === pagination.total_pages ? 'disabled' : ''} 
                data-page="${pagination.current_page + 1}">
            Trang sau
        </button>
    `;

    paginationContainer.innerHTML = html;
} 