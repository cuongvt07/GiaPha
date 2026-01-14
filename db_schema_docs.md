# 📋 Database Schema Documentation - Hệ Thống Gia Phả Việt Nam

## 📊 Tổng Quan
Hệ thống gồm **8 bảng chính** để quản lý đầy đủ thông tin gia phả, hỗ trợ hôn nhân đa thê, phân nhánh họ, và theo dõi thế hệ.

---

## 1️⃣ Bảng `people` - Thông Tin Cá Nhân

**Mục đích:** Lưu trữ toàn bộ thông tin cá nhân của mọi thành viên trong gia phả.

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính, tự tăng | Primary Key |
| `father_id` | `bigint(20) unsigned` | ID của cha | FK → `people.id`, nullable |
| `mother_id` | `bigint(20) unsigned` | ID của mẹ | FK → `people.id`, nullable |
| `family_branch_id` | `bigint(20) unsigned` | ID nhánh họ | FK → `family_branches.id`, nullable |
| `generation_id` | `bigint(20) unsigned` | ID thế hệ/đời | FK → `generations.id`, nullable |
| `root_ancestor_id` | `bigint(20) unsigned` | ID tổ tiên gốc của nhánh này | FK → `people.id`, nullable |
| `name` | `varchar(255)` | Họ tên đầy đủ | **Bắt buộc** |
| `nickname` | `varchar(255)` | Tên thường gọi/biệt danh | Nullable |
| `gender` | `enum('male', 'female')` | Giới tính | **Bắt buộc** |
| `date_of_birth` | `date` | Ngày sinh | Nullable |
| `date_of_death` | `date` | Ngày mất | Nullable (NULL = còn sống) |
| `place_of_birth` | `varchar(255)` | Nơi sinh | Nullable |
| `hometown` | `varchar(255)` | Quê quán/Nguyên quán | Nullable |
| `occupation` | `varchar(255)` | Nghề nghiệp | Nullable |
| `title` | `varchar(255)` | Chức vụ/Học vị | Nullable |
| `biography` | `text` | Tiểu sử chi tiết | Nullable |
| `address` | `varchar(255)` | Địa chỉ hiện tại | Nullable |
| `phone` | `varchar(20)` | Số điện thoại | Nullable |
| `email` | `varchar(255)` | Email liên hệ | Nullable |
| `avatar_path` | `varchar(255)` | Đường dẫn ảnh đại diện | Nullable |
| `birth_order` | `integer` | Thứ tự sinh trong gia đình | Nullable |
| `lineage_position` | `varchar(255)` | Vị trí phả hệ | VD: "Trưởng nam", "Thứ nam", "Tam nam" |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- Self-referencing: Cha/Mẹ → Con
- Thuộc về 1 nhánh họ (`family_branches`)
- Thuộc về 1 thế hệ (`generations`)

---

## 2️⃣ Bảng `marriages` - Hôn Nhân (Hỗ Trợ Đa Thê)

**Mục đích:** Quản lý các mối quan hệ hôn nhân, hỗ trợ đa thê (nhiều vợ).

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính | Primary Key |
| `husband_id` | `bigint(20) unsigned` | ID người chồng | FK → `people.id`, **bắt buộc** |
| `wife_id` | `bigint(20) unsigned` | ID người vợ | FK → `people.id`, **bắt buộc** |
| `marriage_type` | `enum` | Loại hôn nhân | `chinh_thuc`, `vo_le`, `thiep` |
| `marriage_order` | `integer` | Thứ tự vợ | 1 = Vợ cả, 2 = Vợ lẽ thứ 2... |
| `marriage_date` | `date` | Ngày cưới | Nullable |
| `divorce_date` | `date` | Ngày ly hôn | Nullable |
| `status` | `enum` | Trạng thái | `active`, `divorced`, `widowed` |
| `notes` | `text` | Ghi chú thêm | Nullable |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- Liên kết 1 chồng + 1 vợ
- Có nhiều con (`children`)

**Logic:**
- Mỗi cặp chồng-vợ = 1 record
- Nếu đa thê: Cùng `husband_id`, khác `wife_id`, khác `marriage_order`

---

## 3️⃣ Bảng `children` - Quản Lý Con Cái

**Mục đích:** Xác định con thuộc về cuộc hôn nhân nào, thứ tự sinh theo mẹ nào.

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính | Primary Key |
| `person_id` | `bigint(20) unsigned` | ID người con | FK → `people.id`, **bắt buộc** |
| `marriage_id` | `bigint(20) unsigned` | ID cuộc hôn nhân | FK → `marriages.id`, **bắt buộc** |
| `birth_order_overall` | `integer` | Thứ tự sinh chung | Con thứ mấy trong gia đình (1,2,3...) |
| `birth_order_by_mother` | `integer` | Thứ tự theo mẹ | Con thứ mấy của mẹ này (1,2,3...) |
| `child_type` | `enum` | Loại con | `biological`, `adopted`, `step` |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- Liên kết `person` với `marriage`
- Xác định con thuộc vợ nào (qua `marriage_id`)

**Ví dụ:**
```
Ông A có 2 vợ:
- Vợ 1: 3 con → birth_order_by_mother = 1,2,3
- Vợ 2: 2 con → birth_order_by_mother = 1,2
- birth_order_overall = 1,2,3,4,5 (theo thứ tự sinh)
```

---

## 4️⃣ Bảng `family_branches` - Chi Nhánh Dòng Họ

**Mục đích:** Quản lý các nhánh họ (chi), phân chia theo con trưởng/thứ/tam...

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính | Primary Key |
| `root_ancestor_id` | `bigint(20) unsigned` | ID tổ tiên gốc | FK → `people.id`, nullable |
| `parent_branch_id` | `bigint(20) unsigned` | ID nhánh cha | FK → `family_branches.id` (self-ref) |
| `branch_name` | `varchar(255)` | Tên nhánh | VD: "Nhánh Trưởng", "Nhánh Nhị" |
| `branch_location` | `varchar(255)` | Địa điểm nhánh | VD: "Hà Nội", "Huế" |
| `description` | `text` | Mô tả nhánh | Nullable |
| `branch_order` | `integer` | Thứ tự nhánh | 1, 2, 3... |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- Self-referencing: Nhánh cha → Nhánh con
- Có nhiều thành viên (`people`)

**Cấu trúc:**
```
Họ Nguyễn
├─ Nhánh Trưởng (branch_order=1)
│  └─ Nhánh Trưởng-A (con nhánh)
├─ Nhánh Nhị (branch_order=2)
└─ Nhánh Tam (branch_order=3)
```

---

## 5️⃣ Bảng `generations` - Quản Lý Thế Hệ/Đời

**Mục đích:** Quản lý các thế hệ (đời) trong gia phả.

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính | Primary Key |
| `family_branch_id` | `bigint(20) unsigned` | ID nhánh họ | FK → `family_branches.id`, nullable |
| `generation_number` | `integer` | Số đời | 1, 2, 3, 4... |
| `generation_name` | `varchar(255)` | Tên đời | VD: "Đời Tổ", "Đời thứ 5" |
| `description` | `text` | Mô tả | Nullable |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- Thuộc về 1 nhánh họ
- Có nhiều người (`people`)

**Logic:**
- Mỗi nhánh có thể có các đời riêng
- Đời 1 = Tổ tiên gốc
- Đời 2, 3, 4... = Con cháu kế tiếp

---

## 6️⃣ Bảng `burial_info` - Thông Tin Mộ Phần

**Mục đích:** Lưu trữ thông tin nơi an táng của từng người.

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính | Primary Key |
| `person_id` | `bigint(20) unsigned` | ID người đã mất | FK → `people.id`, **bắt buộc** |
| `burial_place` | `varchar(255)` | Địa điểm an táng | VD: "Nghĩa trang X" |
| `burial_date` | `date` | Ngày an táng | Nullable |
| `gps_coordinates` | `varchar(100)` | Tọa độ GPS | VD: "21.0285,105.8542" |
| `grave_type` | `varchar(255)` | Loại mộ | VD: "Mộ đơn", "Mộ đôi", "Mộ gia tộc" |
| `grave_description` | `text` | Mô tả mộ | Nullable |
| `grave_photo_path` | `varchar(255)` | Đường dẫn ảnh mộ | Nullable |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- 1 người có thể có nhiều thông tin mộ (nếu di táng)

---

## 7️⃣ Bảng `achievements` - Công Danh/Thành Tựu

**Mục đích:** Lưu trữ học vị, chức vụ, công trạng của từng người.

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính | Primary Key |
| `person_id` | `bigint(20) unsigned` | ID người | FK → `people.id`, **bắt buộc** |
| `title` | `varchar(255)` | Danh hiệu | VD: "Tiến sĩ", "Giáo sư", "Anh hùng" |
| `achievement_type` | `varchar(255)` | Loại thành tựu | VD: "Học vị", "Công trạng", "Giải thưởng" |
| `achievement_date` | `date` | Ngày đạt được | Nullable |
| `description` | `text` | Mô tả chi tiết | Nullable |
| `display_order` | `integer` | Thứ tự hiển thị | 1, 2, 3... |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- 1 người có thể có nhiều thành tựu

**Ví dụ:**
```
Nguyễn Văn A:
- Tiến sĩ Toán học (2010)
- Giáo sư (2015)
- Anh hùng lao động (2020)
```

---

## 8️⃣ Bảng `relationships` - Quan Hệ Mở Rộng

**Mục đích:** Quản lý các quan hệ đặc biệt không phải cha-mẹ-con thông thường.

| Tên Field | Kiểu Dữ Liệu | Mô Tả | Ghi Chú |
|-----------|--------------|-------|---------|
| `id` | `bigint(20) unsigned` | Khóa chính | Primary Key |
| `person_id` | `bigint(20) unsigned` | ID người thứ nhất | FK → `people.id`, **bắt buộc** |
| `related_person_id` | `bigint(20) unsigned` | ID người có quan hệ | FK → `people.id`, **bắt buộc** |
| `relationship_type` | `enum` | Loại quan hệ | `adopted`, `godparent`, `uncle`, `aunt`, `cousin`... |
| `description` | `text` | Mô tả quan hệ | Nullable |
| `created_at` | `timestamp` | Thời gian tạo | Auto |
| `updated_at` | `timestamp` | Thời gian cập nhật | Auto |

**Quan hệ:**
- Liên kết 2 người với quan hệ đặc biệt

**Các loại quan hệ:**
- `adopted` = Con nuôi
- `godparent` = Cha/Mẹ đỡ đầu
- `uncle/aunt` = Chú/Bác/Cô/Dì
- `cousin` = Anh em họ
- ...

---

## 📌 Lưu Ý Quan Trọng

### 🔗 Quan Hệ Giữa Các Bảng

```
people (cha/mẹ)
  ↓
marriages (hôn nhân)
  ↓
children (con cái)
  ↓
people (thế hệ tiếp theo)
```

### ✅ Ưu Điểm Schema Này

1. **Hỗ trợ đa thê** đầy đủ (nhiều vợ)
2. **Phân nhánh họ** rõ ràng
3. **Theo dõi thế hệ** chính xác
4. **Quản lý mộ phần** chi tiết
5. **Linh hoạt** với quan hệ phức tạp

### 🎯 Use Cases

- Tra cứu phả hệ
- Vẽ cây gia phả
- Tìm kiếm theo nhánh/đời
- Quản lý sự kiện gia tộc
- Báo cáo thống kê
- Tìm đường đến mộ (GPS)

---

## 🚀 Bước Tiếp Theo

1. **Tạo Migration Laravel** cho các bảng này
2. **Tạo Model + Relationships** trong Laravel
3. **Seed dữ liệu mẫu** để test
4. **Xây dựng API CRUD** cho từng bảng
5. **Tạo UI** để nhập liệu và hiển thị cây gia phả

---

**Version:** 1.0  
**Last Updated:** 2026-01-13