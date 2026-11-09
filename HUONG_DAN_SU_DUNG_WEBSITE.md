# TÀI LIỆU HƯỚNG DẪN BÀN GIAO & VẬN HÀNH WEBSITE
**Dự án**: Website Truyền Thông & Đào Tạo - Trung Tâm Tiếng Trung Mỹ Đức (Huế)  
**Tiêu chuẩn**: Dự án bàn giao theo đúng Hợp đồng Scope of Work (Mục 1 đến Mục 10)

---

## 1. THÔNG TIN TRUY CẬP HỆ THỐNG

| Hạng mục | Đường dẫn truy cập | Thông tin tài khoản |
| :--- | :--- | :--- |
| **Website chính thức** | [http://localhost:8080](http://localhost:8080) | Dành cho học viên & khách hàng |
| **Tool Quản lý Website (Admin)** | [http://localhost:8080/wp-admin](http://localhost:8080/wp-admin) | Quản trị viên hệ thống |
| **Quản lý Cơ sở Dữ liệu (phpMyAdmin)** | [http://localhost:8081](http://localhost:8081) | User: `root` / Pass: `rootpassword123` |

---

## 2. NGHIỆM THU THEO HỢP ĐỒNG (SCOPE OF WORK)

### Module 1: Thiết Kế Website Truyền Thông
* [x] **1.1 Giao diện PC/Mobile Home**: Đã hoàn thiện Responsive mượt mà trên iPhone, iPad và Desktop.
* [x] **1.2 Danh mục các Section & Trang con (9 mục)**:
  * [List Về chúng tôi](http://localhost:8080/ve-chung-toi/): Giới thiệu cô Mỹ Đức, 10 năm kinh nghiệm, sứ mệnh giáo dục.
  * [List Hoạt động](http://localhost:8080/hoat-dong/): Lớp học, kỳ thi thử HSK, sự kiện trao chứng chỉ.
  * [List Tư vấn du học](http://localhost:8080/du-hoc/): Học bổng CIS, Học bổng CSC, Du học Đài Loan.
  * [List Cung ứng nhân lực](http://localhost:8080/cung-ung-nhan-luc/): Cung cấp nhân sự tiếng Trung cho doanh nghiệp & việc làm tại Huế.
  * [List Trung tâm tiếng Trung](http://localhost:8080/khoa-hoc/): Các khóa học Giao tiếp, HSK 1-6, HSKK, Trẻ em.
  * **Tool quản lý website**: Trang quản trị WordPress tiếng Việt phân quyền dễ dùng.
  * [Tuyển dụng](http://localhost:8080/tuyen-dung/): Các vị trí tuyển giáo viên, CTV du học.
  * [Blog Tin tức - Giao diện bài đăng](http://localhost:8080/tai-lieu/): Kho cẩm nang và tài liệu luyện thi.
  * [Liên hệ](http://localhost:8080/lien-he/): Form đăng ký + Hệ thống 2 cơ sở tại Huế.

### Module 2: Lập Trình Hiển Thị Trên Website
* [x] **2.1 -> 2.13**: Toàn bộ 10 Section trên Trang chủ đã được lập trình hiển thị liền mạch, tích hợp Anchor links nhảy mượt đến từng phần và liên kết vào trang danh sách chi tiết.

### Module Triển Khai & Vận Hành
* [x] **Mục 5**: Chức năng chat & mạng xã hội đa kênh góc màn hình: **Hotline, Zalo, Messenger, Facebook Fanpage, Tiktok, Youtube, Email**.
* [x] **Mục 5**: Tích hợp Google Maps theo từng chi nhánh:
  * *Cơ sở 1*: 10/2/92 Đặng Huy Trứ, phường Thuận Hoá, Thành phố Huế
  * *Cơ sở 2*: 84 Nguyễn Trãi, phường Phú Xuân, Thành phố Huế
  * *Hotline / Zalo*: **0399.535.981** (Đồng bộ duy nhất toàn hệ thống)
* [x] **Mục 6**: Chức năng chia sẻ link website, bài viết lên Facebook, Zalo và nút Sao chép Link tự động chèn ở chân trang.
* [x] **Mục 7**: Nội dung Content đã được Việt hóa 100% chuẩn nhận diện thương hiệu Tiếng Trung Mỹ Đức.
* [x] **Mục 8**: Cài đặt **Rank Math SEO**, cấu hình Title, Description, Schema EducationalOrganization và 2 chi nhánh LocalBusiness.
* [x] **Mục 9**: Chuẩn hóa Typography toàn diện: Sử dụng font **`Be Vietnam Pro`** (thiết kế chuyên biệt cho tiếng Việt có dấu) kết hợp bộ fallback chữ Hán (`PingFang SC`, `Microsoft YaHei`, `Noto Sans SC`), loại bỏ hoàn toàn hiện tượng lỗi font, nhảy cỡ, lệch dấu tiếng Việt.
* [x] **Mục 10**: Tài liệu hướng dẫn sử dụng và bàn giao (File này).

---

## 3. HƯỚNG DẪN QUẢN TRỊ VIÊN SỬ DỤNG HẰNG NGÀY

### 3.1 Cách Đăng Bài Viết / Cẩm Nang Mới
1. Đăng nhập vào [Trang quản trị](http://localhost:8080/wp-admin).
2. Chọn menu **Bài viết (Posts) -> Thêm bài mới (Add New)**.
3. Nhập Tiêu đề bài viết và nội dung.
4. Kéo xuống phần **Rank Math SEO** bên dưới để điền từ khóa chính (Focus Keyword), kiểm tra điểm SEO (xanh lá cây là đạt chuẩn).
5. Đặt **Ảnh đại diện bài viết (Featured Image)** ở cột bên phải.
6. Nhấn nút **Đăng (Publish)**. Hệ thống sẽ tự động thêm bộ nút chia sẻ Facebook & Zalo ở cuối bài viết.

### 3.2 Form Đăng Ký Tư Vấn và Email Nhận Thông Tin
* Form Contact Form 7 (ID `22542`) hiển thị trên trang chủ và trang [Liên hệ](http://localhost:8080/lien-he/). Thông tin được cấu hình gửi đến `tiengtrungcomyduc@gmail.com`.
* Các trường họ tên, số điện thoại, email, chương trình học và cơ sở/nguyện vọng đã được nối với nội dung email. Contact Form 7 không lưu danh sách đăng ký trong trang quản trị nếu chưa cài thêm công cụ lưu dữ liệu.
* Đã chuẩn bị luồng gửi qua Gmail SMTP nhưng môi trường hiện chưa có tài khoản gửi/App Password. Sao chép `.env.example` thành `.env`, nhập Gmail tại `MYDUC_SMTP_USERNAME` và Google App Password tại `MYDUC_SMTP_APP_PASSWORD`, sau đó chạy lại container WordPress. Tài khoản cần bật xác minh 2 bước và được phép tạo App Password; không dùng mật khẩu Gmail thông thường.
* Tệp `.env` đã được loại khỏi Git; không đưa App Password vào mã nguồn, cơ sở dữ liệu hoặc nội dung chat. Chưa thể xác nhận email gửi thành công cho đến khi điền cấu hình SMTP thật và thử với sự đồng ý của Trung tâm.
* Trong trang Admin, vào mục **Contact (Liên hệ) → Contact Forms** để chỉnh sửa cấu hình form; mục này không phải danh sách học viên đã gửi đăng ký.

### 3.3 Hướng Dẫn Chỉnh Sửa Giao Diện & Nội Dung Trực Quan (Elementor)

#### A. Các Phương Thức Truy Cập Trình Chỉnh Sửa Elementor
* **Cách 1: Truy cập qua liên kết trực tiếp**  
  [Chỉnh sửa Trang Chủ với Elementor](http://localhost:8080/wp-admin/post.php?post=17&action=elementor) `(http://localhost:8080/wp-admin/post.php?post=17&action=elementor)`
* **Cách 2: Truy cập từ Trang Quản Trị (Admin Dashboard)**  
  1. Đăng nhập trang quản trị: `http://localhost:8080/wp-admin/`
  2. Chọn menu **Trang (Pages) -> Tất cả các trang (All Pages)**.
  3. Tìm trang **Trang chủ** (Front Page) và chọn **Chỉnh sửa với Elementor (Edit with Elementor)**.
* **Cách 3: Truy cập qua thanh công cụ Admin Bar**  
  1. Khi đang xem trang ngoài thực tế, chọn **Chỉnh sửa trang (Edit Page)** trên thanh công cụ phía trên.
  2. Tại trang chỉnh sửa cấu hình, nhấn nút **Edit with Elementor**.

#### B. Cấu Trúc Giao Diện Elementor
Giao diện bao gồm 2 phân vùng làm việc chính:
1. **Khung xem trước trực quan (Bên phải - Chiếm 75% màn hình):** Hiển thị giao diện thực tế của website. Bấm chuột trái vào đối tượng để chọn phần tử cần chỉnh sửa.
2. **Bảng điều khiển (Cột bên trái - Chiếm 25% màn hình):** Bao gồm 3 tab chức năng:
   * **Nội dung (Content):** Chỉnh sửa văn bản, hình ảnh, liên kết điều hướng.
   * **Kiểu dáng (Style):** Cấu hình màu sắc, phông chữ, kích thước, đường viền.
   * **Nâng cao (Advanced):** Cấu hình khoảng cách (Margin/Padding), hiển thị phân tầng, ẩn/hiện theo thiết bị.

#### C. Quy Trình Chỉnh Sửa Từng Thành Phần
1. **Chỉnh sửa Tiêu đề và Văn bản:**
   * *Bước 1:* Bấm chuột trái vào khối văn bản cần sửa trên khung xem trước.
   * *Bước 2:* Tại cột bên trái (tab *Nội dung*), chỉnh sửa nội dung trong trường **Tiêu đề (Title)** hoặc khung soạn thảo.
   * *Lưu ý:* Luôn nhập liệu tại ô ở cột bên trái để đảm bảo tính toàn vẹn của cấu trúc HTML và các biểu tượng định dạng.
2. **Thay đổi Hình ảnh:**
   * *Bước 1:* Bấm chuột trái vào hình ảnh cần thay đổi trên khung xem trước.
   * *Bước 2:* Tại cột bên trái, bấm vào khung hình thu nhỏ hoặc nút **Chọn ảnh (Choose Image)**.
   * *Bước 3:* Chọn hình ảnh có sẵn từ **Thư viện (Media Library)** hoặc chuyển sang tab **Tải tập tin lên (Upload Files)** để thêm ảnh mới từ máy tính, sau đó nhấn **Chèn Media (Insert Media)**.
3. **Chỉnh sửa Nút bấm & Liên kết Điều hướng:**
   * *Bước 1:* Bấm chuột trái vào nút bấm cần cấu hình.
   * *Bước 2:* Tại tab *Nội dung* ở cột bên trái:
     * Trường **Văn bản (Text):** Nhập nhãn hiển thị của nút.
     * Trường **Liên kết (Link):** 
       * Cuộc gọi trực tiếp: định dạng `tel:0905123456`
       * Liên kết Zalo: định dạng `https://zalo.me/0905123456`
       * Liên kết ngoài: dán URL tương ứng và tích chọn **Mở trong tab mới** tại biểu tượng Cài đặt.
4. **Chỉnh sửa Khối Hỏi Đáp (FAQ) và Bảng Giá:**
   * *Bước 1:* Bấm chuột trái vào khối FAQ hoặc bảng giá tương ứng.
   * *Bước 2:* Tại danh sách các mục ở cột bên trái, mở từng mục cần chỉnh sửa.
   * *Bước 3:* Cập nhật thông tin tại trường **Tiêu đề** và trường **Mô tả/Nội dung**.
   * *Bước 4:* Sử dụng nút **Thêm mục (Add Item)** để bổ sung hoặc nhấn biểu tượng xóa để loại bỏ mục không cần thiết.

#### D. Quy Trình Lưu Trữ & Xuất Bản
1. Sau khi hoàn tất chỉnh sửa, quan sát thanh công cụ:
   * **Giao diện mới (Top Bar):** Nhấn nút **`Publish`** hoặc **`Update`** màu hồng tím nằm ở **Góc trên cùng bên phải màn hình**.
   * **Phím tắt chuẩn:** Nhấn tổ hợp phím **`Ctrl + S`** trên bàn phím để lưu trang tức thì mà không cần tìm vị trí nút.
2. Trạng thái lưu thành công được xác nhận khi nút chuyển sang trạng thái mờ đi (hoặc đổi màu nhạt).
3. Nhấn biểu tượng **Con Mắt (Xem trước thay đổi / Preview)** trên thanh công cụ để kiểm tra hiển thị thực tế trên thẻ mới.

#### E. Tính Năng Phục Hồi & An Toàn Dữ Liệu
* **Hoàn tác thao tác (Undo):** Sử dụng tổ hợp phím **`Ctrl + Z`** để quay lại trạng thái liền trước khi thao tác sai.
* **Khôi phục phiên bản (History):** Chọn biểu tượng **Lịch sử** ở góc dưới thanh công cụ để khôi phục phiên bản nội dung tại mốc thời gian mong muốn.
* **Hủy thay đổi chưa lưu:** Trường hợp phát sinh lỗi giao diện ngoài ý muốn, đóng tab trình duyệt mà không nhấn nút Cập nhật; toàn bộ dữ liệu đang hoạt động của website sẽ được giữ nguyên trạng.

### 3.4 Hệ Thống Phông Chữ & Nhận Diện Thương Hiệu
* Phông chữ chủ đạo: **Be Vietnam Pro** (Google Fonts) – hiển thị mượt mà trên mọi thiết bị iOS, Android, macOS, Windows.
* Bộ ký tự tiếng Trung song ngữ: Tự động nhận diện chữ Hán (HSK, ngữ pháp, tên trung tâm 德) qua các font chuẩn quốc tế `PingFang SC`, `Microsoft YaHei`.
* Logo thương hiệu: Huy hiệu tròn viền Hoàng Gia (Gold + Crimson Red), có hiệu ứng phóng nhẹ khi di chuột.
