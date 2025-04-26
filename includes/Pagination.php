<?php
/**
 * File: includes/Pagination.php
 * Mô tả: Lớp Pagination để xử lý phân trang dữ liệu
 * Cung cấp các phương thức để tính toán và lấy thông tin phân trang
 */

/**
 * Lớp Pagination
 * Quản lý logic phân trang cho danh sách sản phẩm
 */
class Pagination {
    /**
     * Tổng số bản ghi
     * @var int
     */
    private $total_records;
    
    /**
     * Số bản ghi trên mỗi trang
     * @var int
     */
    private $records_per_page;
    
    /**
     * Trang hiện tại
     * @var int
     */
    private $current_page;
    
    /**
     * Tổng số trang
     * @var int
     */
    private $total_pages;

    /**
     * Constructor
     * @param int $total_records Tổng số bản ghi
     * @param int $records_per_page Số bản ghi trên mỗi trang (mặc định: 5)
     * @param int $current_page Trang hiện tại (mặc định: 1)
     */
    public function __construct($total_records, $records_per_page = 5, $current_page = 1) {
        $this->total_records = $total_records;
        $this->records_per_page = $records_per_page;
        $this->current_page = $current_page;
        $this->total_pages = ceil($total_records / $records_per_page);
    }

    /**
     * Lấy vị trí bắt đầu để truy vấn database
     * @return int Vị trí bắt đầu
     */
    public function getOffset() {
        return ($this->current_page - 1) * $this->records_per_page;
    }

    /**
     * Lấy số bản ghi trên mỗi trang
     * @return int Số bản ghi trên mỗi trang
     */
    public function getLimit() {
        return $this->records_per_page;
    }

    /**
     * Lấy tổng số trang
     * @return int Tổng số trang
     */
    public function getTotalPages() {
        return $this->total_pages;
    }

    /**
     * Lấy trang hiện tại
     * @return int Trang hiện tại
     */
    public function getCurrentPage() {
        return $this->current_page;
    }

    /**
     * Kiểm tra xem có trang tiếp theo không
     * @return bool true nếu có trang tiếp theo, false nếu không
     */
    public function hasNextPage() {
        return $this->current_page < $this->total_pages;
    }

    /**
     * Kiểm tra xem có trang trước đó không
     * @return bool true nếu có trang trước đó, false nếu không
     */
    public function hasPreviousPage() {
        return $this->current_page > 1;
    }

    /**
     * Lấy số trang tiếp theo
     * @return int Số trang tiếp theo hoặc trang cuối cùng nếu đang ở trang cuối
     */
    public function getNextPage() {
        return $this->hasNextPage() ? $this->current_page + 1 : $this->total_pages;
    }

    /**
     * Lấy số trang trước đó
     * @return int Số trang trước đó hoặc trang đầu tiên nếu đang ở trang đầu
     */
    public function getPreviousPage() {
        return $this->hasPreviousPage() ? $this->current_page - 1 : 1;
    }

    /**
     * Lấy danh sách số trang để hiển thị
     * Tạo danh sách các số trang với dấu ... để biểu thị các trang bị bỏ qua
     * @return array Danh sách số trang
     */
    public function getPageNumbers() {
        $pages = [];
        $start = max(1, $this->current_page - 2);
        $end = min($this->total_pages, $this->current_page + 2);

        // Thêm trang đầu tiên và dấu ... nếu cần
        if ($start > 1) {
            $pages[] = 1;
            if ($start > 2) {
                $pages[] = '...';
            }
        }

        // Thêm các trang xung quanh trang hiện tại
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        // Thêm dấu ... và trang cuối cùng nếu cần
        if ($end < $this->total_pages) {
            if ($end < $this->total_pages - 1) {
                $pages[] = '...';
            }
            $pages[] = $this->total_pages;
        }

        return $pages;
    }
}
?> 