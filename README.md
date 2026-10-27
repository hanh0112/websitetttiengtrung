# Website Trung Tâm Đào Tạo Tiếng Trung & Du Học Mỹ Đức (Huế)

Hệ thống Website Đào Tạo Ngoại Ngữ, Cung Ứng Nhân Lực & Tư Vấn Du Học dành cho **Trung Tâm Tiếng Trung Cô Mỹ Đức (Thừa Thiên Huế)**. 
Xây dựng trên nền tảng **WordPress 6.x + Elementor Pro + LMS Education Theme**, vận hành tự động bằng **Docker Compose**.

---

## 1. Thông Tin Truy Cập Nhanh

| Hạng mục | Địa chỉ truy cập | Ghi chú |
| :--- | :--- | :--- |
| **Website Chính Thức** | [http://localhost:8080](http://localhost:8080) | Dành cho học viên & doanh nghiệp |
| **Trang Quản Trị (Admin)** | [http://localhost:8080/wp-admin](http://localhost:8080/wp-admin) | Quản lý nội dung, khóa học, đơn đăng ký |
| **Quản Lý Cơ Sở Dữ Liệu (phpMyAdmin)** | [http://localhost:8081](http://localhost:8081) | User: `root` / Pass: `rootpassword123` |

---

## 2. Cấu Trúc Mã Nguồn

```text
├── docker-compose.yml              # Cấu hình triển khai Docker (WordPress, MariaDB, phpMyAdmin)
├── database.sql                    # Bản sao lưu CSDL hoàn chỉnh (Đầy đủ trang, khóa học, dữ liệu Elementor)
├── HUONG_DAN_SU_DUNG_WEBSITE.md    # Cẩm nang hướng dẫn bàn giao & vận hành chi tiết
├── README.md                       # Tài liệu hướng dẫn cài đặt & triển khai
├── uploads.ini                     # Cấu hình PHP tối ưu (memory_limit: 512M, upload: 256M)
├── .htaccess                       # Cấu hình rewrite URL chuẩn SEO WordPress
└── wp-content/
    ├── themes/
    │   ├── livi/                   # Parent Theme (Livi Education Theme v1.0.5)
    │   └── livi-child/             # Child Theme kích hoạt (Chứa CSS, Fonts & Functions tiếng Việt)
    └── plugins/
        ├── livi-plus/              # Plugin mở rộng tính năng theme
        ├── livi-pro/               # Plugin nâng cao
        ├── livi-shop/              # Plugin tích hợp bán hàng / học phí
        ├── wedesigntech-elementor-addon/ # Bộ widget Elementor chuyên biệt
        └── wedesigntech-lms-addon/       # Hệ thống quản lý học tập & khóa học LMS
```

---

## 3. Hướng Dẫn Cài Đặt & Triển Khai (Dành cho máy mới)

### Bước 1: Khởi động hệ thống với Docker
Mở Terminal/PowerShell tại thư mục dự án và chạy:
```bash
docker compose up -d
```

### Bước 2: Khôi phục Cơ Sở Dữ Liệu (Database Import)
Nhập toàn bộ dữ liệu trang web từ file `database.sql`:
```bash
docker exec -i wordpress_db mysql -u root -prootpassword123 wordpress < database.sql
```

Sau khi import thành công, truy cập ngay [http://localhost:8080](http://localhost:8080) để trải nghiệm toàn bộ hệ thống.

---

## 4. Các Lệnh Quản Trị Hệ Thống Thường Dùng

* **Tạm dừng hệ thống:**
  ```bash
  docker compose stop
  ```
* **Khởi động lại:**
  ```bash
  docker compose start
  ```
* **Xem nhật ký hoạt động (Logs):**
  ```bash
  docker compose logs -f
  ```
* **Xuất bản sao lưu CSDL mới nhất:**
  ```bash
  docker exec wordpress_db mysqldump -u root -prootpassword123 wordpress > database.sql
  ```
