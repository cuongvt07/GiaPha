# 🎨 UI/UX Design Guide - Hệ Thống Gia Phả Việt Nam

## 🎯 Mục Tiêu Thiết Kế

**Tập trung vào trải nghiệm 1 trang (Single Page Application)**
- ✅ Mọi thao tác diễn ra trên 1 trang duy nhất
- ✅ Không reload page, mượt mà như ứng dụng desktop
- ✅ Dễ sử dụng cho mọi lứa tuổi (từ 18-80 tuổi)
- ✅ Responsive: Desktop, Tablet, Mobile

---

## 📐 Layout Chính - Single Page Experience

### 🖥️ Desktop Layout (1920x1080)

```
┌──────────────────────────────────────────────────────────────┐
│  HEADER - Cố định 60px                                       │
│  [Logo] Gia Phả Họ Nguyễn    [Search] [+Thêm] [User] [Menu]│
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────┐  ┌──────────────────────────────────────┐│
│  │              │  │                                        ││
│  │   SIDEBAR    │  │        MAIN CANVAS                     ││
│  │   240px      │  │        (Cây gia phả tương tác)         ││
│  │              │  │                                        ││
│  │ • Dashboard  │  │                                        ││
│  │ • Cây gia phả│  │    [Zoom In/Out] [Pan] [Reset View]   ││
│  │ • Nhánh họ   │  │                                        ││
│  │ • Thế hệ     │  │                                        ││
│  │ • Tìm kiếm   │  │                                        ││
│  │ • Thống kê   │  │                                        ││
│  │ • Cài đặt    │  │                                        ││
│  │              │  │                                        ││
│  └──────────────┘  └──────────────────────────────────────┘│
│                                                              │
└──────────────────────────────────────────────────────────────┘
         ↑                            ↑
    Có thể thu gọn            Khu vực chính tương tác
```

### 📱 Mobile Layout (375x812)

```
┌─────────────────────┐
│ ☰  Gia Phả  🔍 👤  │ ← Header 56px
├─────────────────────┤
│                     │
│   MAIN CANVAS       │
│   (Full screen)     │
│                     │
│   [Zoom] [Pan]      │
│                     │
│   Swipe để xem →    │
│                     │
│                     │
└─────────────────────┘
│ [+] [◉] [≡] [⚙]   │ ← Bottom Nav
└─────────────────────┘
```

---

## 🎨 Màu Sắc & Phong Cách

### 🎨 Color Palette - Tone Truyền Thống Việt Nam

```
Primary Colors (Màu chủ đạo):
├─ Đỏ Truyền Thống:   #C41E3A  (Đỏ thờ cúng, may mắn)
├─ Vàng Hoàng Kim:    #FFD700  (Vàng sang trọng)
└─ Nâu Gỗ:            #8B4513  (Nâu gỗ nhà thờ họ)

Secondary Colors:
├─ Xanh Lá Nhạt:      #90EE90  (Sự sống, kế thừa)
├─ Xám Đá:            #708090  (Trung tính, hiện đại)
└─ Trắng Ngọc:        #FFFAF0  (Nền sáng, thanh lịch)

Status Colors:
├─ Còn sống:          #22C55E  (Xanh lá)
├─ Đã mất:            #6B7280  (Xám)
├─ Nam:               #3B82F6  (Xanh dương)
└─ Nữ:                #EC4899  (Hồng)
```

### 🖋️ Typography

```
Font Chính:
- Tiếng Việt: "Inter", "Be Vietnam Pro", sans-serif
- Fallback: Arial, sans-serif

Kích thước:
├─ H1: 32px (Bold) - Tiêu đề chính
├─ H2: 24px (Semibold) - Tiêu đề phụ
├─ H3: 18px (Medium) - Mục lục
├─ Body: 16px (Regular) - Nội dung
└─ Caption: 14px (Regular) - Chú thích
```

---

## 🗺️ Các Thành Phần Chính Trên 1 Trang

### 1. **Header Bar (Cố định trên cùng)**

```
┌─────────────────────────────────────────────────────────┐
│ [🏠 Logo] Gia Phả Họ Nguyễn                             │
│                                                          │
│     [🔍 Tìm kiếm nhanh...]  [+ Thêm người]  [👤 Admin]  │
└─────────────────────────────────────────────────────────┘

Features:
✅ Tìm kiếm real-time (gõ tức hiển thị)
✅ Quick add member (modal popup)
✅ User menu: Profile, Settings, Logout
✅ Breadcrumb: Bạn đang xem > Nhánh Trưởng > Đời 5
```

### 2. **Sidebar Navigation (Collapsible)**

```
┌─────────────────┐
│ 📊 Dashboard    │
│ 🌳 Cây gia phả  │ ← Active
│ 🏘️ Nhánh họ     │
│ 🧬 Thế hệ       │
│ 🔍 Tìm kiếm     │
│ 📈 Thống kê     │
│ ⚙️ Cài đặt      │
├─────────────────┤
│ Filters:        │
│ □ Chỉ còn sống  │
│ □ Nam           │
│ □ Nữ            │
│ ▼ Nhánh: Tất cả │
│ ▼ Đời: Tất cả   │
└─────────────────┘

Tính năng:
✅ Có thể thu gọn thành icon (48px)
✅ Active state rõ ràng
✅ Bộ lọc nhanh ngay sidebar
✅ Sticky scroll (luôn hiển thị khi cuộn)
```

### 3. **Main Canvas - Cây Gia Phả Tương Tác**

#### 🌳 Cách Hiển Thị Cây

**Chế độ mặc định: Horizontal Tree (Ngang)**

```
       Ông Tổ (Đời 1)
           │
    ┌──────┴──────┐
    │             │
 Con 1        Con 2
 (Đời 2)     (Đời 2)
    │             │
 ┌──┴──┐      ┌──┴──┐
 │     │      │     │
Cháu Cháu   Cháu Cháu
(Đời 3)     (Đới 3)
```

**Chế độ thay thế: Vertical Tree (Dọc)**

```
Tổ → Con 1 → Cháu 1 → Chắt 1
      │
      └─→ Cháu 2 → Chắt 2
```

#### 🎮 Tương Tác Với Cây

```
Zoom & Pan:
├─ [+] [-] Zoom buttons (góc trên phải)
├─ Mouse wheel để zoom
├─ Click + drag để pan
├─ Double click node để center view
└─ [Reset View] button

Node Actions:
├─ Click node → Hiện Quick Info Card
├─ Double click → Mở Detail Panel (slide từ phải)
├─ Right click → Context Menu
│   ├─ Xem chi tiết
│   ├─ Chỉnh sửa
│   ├─ Thêm con
│   ├─ Thêm vợ/chồng
│   └─ Xóa (có xác nhận)
└─ Hover → Highlight relationships
```

### 4. **Person Node Card Design**

```
┌─────────────────────────┐
│  [Ảnh 80x80]           │
│                         │
│  Nguyễn Văn A          │ ← Tên (Bold, 16px)
│  (1950 - 2020) 🕊️      │ ← Năm sinh - mất
│                         │
│  👨 Nam                 │ ← Giới tính
│  🏘️ Nhánh Trưởng       │ ← Nhánh
│  🧬 Đời 4               │ ← Thế hệ
│                         │
│  [👁️ Xem]  [✏️ Sửa]    │ ← Quick actions
└─────────────────────────┘

Màu sắc node:
├─ Còn sống: Viền xanh lá #22C55E
├─ Đã mất: Viền xám #6B7280
├─ Nam: Background xanh nhạt #EFF6FF
└─ Nữ: Background hồng nhạt #FDF2F8
```

### 5. **Detail Panel (Slide từ bên phải)**

```
┌────────────────────────────┐
│  ← Đóng                  X │
├────────────────────────────┤
│                            │
│   [Ảnh đại diện 200x200]  │
│                            │
│   Nguyễn Văn A             │
│   (1950 - 2020)            │
│                            │
│ ┌─ TAB NAVIGATION ───────┐│
│ │ Thông tin | Gia đình | │
│ │ Tiểu sử | Mộ phần     ││
│ └──────────────────────────┘
│                            │
│ 📋 Thông tin cơ bản:       │
│ • Họ tên: Nguyễn Văn A    │
│ • Giới tính: Nam          │
│ • Ngày sinh: 01/01/1950   │
│ • Quê quán: Hà Nội        │
│ • Nghề nghiệp: Giáo viên  │
│                            │
│ 👨‍👩‍👧‍👦 Gia đình:              │
│ • Cha: Nguyễn Văn B       │
│ • Mẹ: Trần Thị C          │
│ • Vợ: Lê Thị D (Vợ cả)   │
│ • Con: 3 người            │
│   - Nguyễn Văn E (1975)   │
│   - Nguyễn Thị F (1977)   │
│   - Nguyễn Văn G (1980)   │
│                            │
│ [Chỉnh sửa] [Xóa]         │
└────────────────────────────┘

Width: 480px (Desktop), Full screen (Mobile)
Animation: Slide in từ phải 300ms
```

---

## 🎬 Các Chức Năng Chính & Flow

### 1. **Thêm Người Mới**

**Button:** Header → `[+ Thêm người]`

**Modal Popup:**
```
┌──────────────────────────────┐
│  Thêm Thành Viên Mới      X  │
├──────────────────────────────┤
│                              │
│  [Upload ảnh]                │
│                              │
│  Họ tên: [____________]      │
│  Giới tính: ○ Nam ○ Nữ       │
│  Ngày sinh: [DD/MM/YYYY]     │
│                              │
│  ━━━ Quan hệ gia đình ━━━    │
│  Cha: [Tìm kiếm...     ▼]    │
│  Mẹ: [Tìm kiếm...      ▼]    │
│  Vợ/Chồng: [Thêm...    +]    │
│                              │
│  ━━━ Phân loại ━━━           │
│  Nhánh họ: [Chọn...    ▼]    │
│  Thế hệ: [Đời 5        ▼]    │
│                              │
│     [Hủy]    [💾 Lưu]        │
└──────────────────────────────┘

Features:
✅ Auto-suggest khi gõ tên cha/mẹ
✅ Tự động tính thế hệ dựa vào cha/mẹ
✅ Validate: Không được bỏ trống tên, giới tính
✅ Sau khi lưu: Tự động focus vào node mới trên cây
```

### 2. **Tìm Kiếm Nhanh**

**Input:** Header → `[🔍 Tìm kiếm...]`

**Dropdown Results (Real-time):**
```
┌────────────────────────────┐
│ Kết quả cho "Nguyễn Văn"   │
├────────────────────────────┤
│ [👤] Nguyễn Văn A          │
│      (1950-2020) Đời 4     │
│                            │
│ [👤] Nguyễn Văn B          │
│      (1975-) Đời 5         │
│                            │
│ [👤] Nguyễn Văn C          │
│      (1980-) Đời 5         │
│                            │
│ → Xem tất cả 15 kết quả    │
└────────────────────────────┘

Tính năng:
✅ Search ngay khi gõ (debounce 300ms)
✅ Highlight text khớp
✅ Click result → Focus vào node trên cây
✅ Hiển thị max 5 kết quả, có link "Xem tất cả"
✅ Search trong: Tên, nickname, năm sinh, nhánh, đời
```

### 3. **Lọc & Hiển Thị**

**Sidebar Filters:**
```
━━━ Bộ lọc hiển thị ━━━

☑ Chỉ hiện người còn sống
☐ Chỉ hiện nam
☐ Chỉ hiện nữ

Nhánh họ:
▼ [Tất cả        ▼]
  ├─ Tất cả
  ├─ Nhánh Trưởng
  ├─ Nhánh Nhị
  └─ Nhánh Tam

Thế hệ:
▼ [Tất cả        ▼]
  ├─ Tất cả
  ├─ Đời 1-3
  ├─ Đời 4-6
  └─ Đời 7+

Năm sinh:
[1900] ──●────── [2025]

[🔄 Reset bộ lọc]

Effect:
✅ Real-time update cây (fade in/out nodes)
✅ Hiển thị số lượng: "Hiện 45/230 người"
✅ Smooth animation
```

### 4. **Dashboard - Overview**

**Click Sidebar → 📊 Dashboard**

**Layout:**
```
┌─────────────────────────────────────────┐
│  📊 Tổng Quan Gia Phả                   │
├─────────────────────────────────────────┤
│                                         │
│  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐  │
│  │ 230  │ │ 180  │ │  50  │ │  12  │  │
│  │Người │ │Còn   │ │Đã    │ │ Đời  │  │
│  └──────┘ └──────┘ └──────┘ └──────┘  │
│                                         │
│  ━━━━━ Thống kê theo nhánh ━━━━━       │
│  📊 Bar Chart:                          │
│     Nhánh Trưởng  ████████ 120         │
│     Nhánh Nhị     █████ 70             │
│     Nhánh Tam     ████ 40              │
│                                         │
│  ━━━━━ Biểu đồ độ tuổi ━━━━━           │
│  📈 Line Chart: Phân bố theo đời        │
│                                         │
│  ━━━━━ Sự kiện gần đây ━━━━━           │
│  • Thêm: Nguyễn Văn X (2 giờ trước)   │
│  • Sửa: Trần Thị Y (1 ngày trước)     │
│  • Thêm: Lê Văn Z (3 ngày trước)      │
│                                         │
└─────────────────────────────────────────┘
```

---

## 🎯 Trải Nghiệm Người Dùng (UX Flow)

### ⚡ Kịch Bản 1: Người dùng mới vào hệ thống

```
1. Landing → Hiện cây gia phả với zoom fit-to-screen
2. Hiện tooltip hướng dẫn:
   "👋 Chào mừng! Click vào node để xem chi tiết"
3. Highlight node Tổ tiên (gốc cây)
4. User click node → Hiện Quick Info
5. User click "Xem chi tiết" → Slide Detail Panel
6. ✅ Hoàn thành onboarding
```

### ⚡ Kịch Bản 2: Thêm người vào gia phả

```
1. Click [+ Thêm người] header
2. Modal popup
3. Nhập thông tin (Họ tên bắt buộc)
4. Chọn cha/mẹ (auto-suggest)
5. Hệ thống tự động:
   ├─ Tính thế hệ
   ├─ Gán nhánh họ
   └─ Tính thứ tự sinh
6. Click [Lưu]
7. ✅ Success toast: "Đã thêm Nguyễn Văn A"
8. Cây tự động zoom & focus vào node mới
9. Highlight node mới (blink 2 lần)
```

### ⚡ Kịch Bản 3: Tìm người trong gia phả lớn

```
1. Gõ vào search box: "Nguyễn Văn A"
2. Dropdown hiện ngay khi gõ (real-time)
3. Click result
4. ✅ Cây auto zoom + pan đến node
5. Node blink 2 lần để highlight
6. Quick Info Card tự động hiện
```

### ⚡ Kịch Bản 4: Sửa thông tin người đã mất

```
1. Tìm người → Click node
2. Detail Panel slide in
3. Click tab "Mộ phần"
4. Click [Chỉnh sửa]
5. Form hiện inline:
   ├─ Địa điểm an táng
   ├─ Ngày an táng
   ├─ Tọa độ GPS (có nút "📍 Lấy vị trí")
   └─ Upload ảnh mộ
6. Click [Lưu]
7. ✅ Success: "Đã cập nhật thông tin mộ phần"
```

---

## 📱 Responsive Design

### 💻 Desktop (1920px+)
- Sidebar 240px + Main Canvas full width
- Hiển thị full tree với nhiều đời cùng lúc
- Detail Panel slide từ phải (480px)

### 💻 Tablet (768px - 1024px)
- Sidebar collapse thành icon bar (48px)
- Main Canvas chiếm hết không gian
- Detail Panel full width overlay

### 📱 Mobile (< 768px)
- Sidebar ẩn hoàn toàn → Hamburger menu
- Bottom Navigation: [+] [Home] [Search] [Menu]
- Detail Panel: Full screen modal
- Tree: Zoom mặc định lớn hơn (focus 1-2 đời)
- Swipe gestures: Swipe left/right để navigate tree

---

## 🎨 Microinteractions & Animations

### ✨ Animations Quan Trọng

```css
/* Node hover effect */
.node:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 16px rgba(0,0,0,0.2);
  transition: all 0.2s ease;
}

/* Add new node animation */
@keyframes slideInScale {
  0% { opacity: 0; transform: scale(0.5); }
  100% { opacity: 1; transform: scale(1); }
}

/* Connection line draw */
@keyframes drawLine {
  from { stroke-dashoffset: 1000; }
  to { stroke-dashoffset: 0; }
}

/* Focus/Highlight effect */
@keyframes pulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(196, 30, 58, 0.7); }
  50% { box-shadow: 0 0 0 10px rgba(196, 30, 58, 0); }
}

/* Panel slide in */
@keyframes slideInRight {
  from { transform: translateX(100%); }
  to { transform: translateX(0); }
}
```

### 🎭 Loading States

```
1. Initial Load:
   ┌─────────────────┐
   │   🌳 Đang tải   │
   │   gia phả...    │
   │   [Spinner]     │
   └─────────────────┘

2. Saving Data:
   [💾 Đang lưu...] → [✅ Đã lưu!]
   Toast hiện 2s rồi tự ẩn

3. Search Loading:
   [🔍 Tìm kiếm...] trong input

4. Node Skeleton:
   ┌─────────────┐
   │ ▓▓▓▓▓▓▓    │ ← Shimmer effect
   │ ▓▓▓▓       │
   └─────────────┘
```

---

## ♿ Accessibility (A11y)

```
Keyboard Navigation:
├─ Tab: Di chuyển giữa các node
├─ Enter: Mở detail của node đang focus
├─ Esc: Đóng modal/panel
├─ Arrow keys: Di chuyển giữa nodes (khi focus vào tree)
└─ Ctrl+F: Focus vào search box

Screen Reader Support:
├─ Alt text cho tất cả icons
├─ ARIA labels cho interactive elements
├─ Announce khi có update (live region)
└─ Semantic HTML (nav, main, article, aside)

Contrast Ratio:
├─ Text: Tối thiểu 4.5:1
├─ Large text: Tối thiểu 3:1
└─ Icons: Tối thiểu 3:1

Focus States:
├─ Visible outline cho tất cả focusable elements
└─ Focus trap trong modal
```

---

## 🚀 Performance Optimization

### ⚡ Lazy Loading
```
1. Chỉ render nodes trong viewport
2. Virtual scrolling cho danh sách dài
3. Lazy load images (avatar)
4. Code splitting per route
```

### 🎯 Optimization Strategies
```
Tree Rendering:
├─ Chỉ render visible nodes (viewport)
├─ Use Canvas/SVG cho connection lines
├─ Debounce zoom/pan events (16ms)
└─ Memoize node components

Data Fetching:
├─ Fetch initial data (1 API call)
├─ Lazy load detail khi click node
├─ Cache data in localStorage
└─ Prefetch likely next actions

Bundle Size:
├─ Code splitting
├─ Tree shaking
├─ Compress images (WebP)
└─ Lazy load heavy libraries
```

---

## 🎯 Prioritized Features (MVP)

### Phase 1 - Core (Week 1-2)
- ✅ Display family tree (horizontal layout)
- ✅ Add/Edit/Delete person
- ✅ Basic search
- ✅ Node click → Detail panel

### Phase 2 - Enhancement (Week 3-4)
- ✅ Zoom/Pan interactions
- ✅ Filters (branch, generation, status)
- ✅ Dashboard statistics
- ✅ Responsive mobile

### Phase 3 - Advanced (Week 5-6)
- ✅ Multiple spouse support
- ✅ Burial info management
- ✅ Photo gallery
- ✅ Export PDF family tree

### Phase 4 - Nice-to-have
- 🔄 Real-time collaboration
- 🔄 Version history
- 🔄 AI-powered relationship suggestions
- 🔄 3D tree visualization

---

## 📐 Component Library Recommendations

```
UI Framework:
├─ React.js hoặc Vue.js
└─ TailwindCSS cho styling

Tree Visualization:
├─ D3.js (powerful, flexible)
├─ React Flow (easy, React-friendly)
└─ Cytoscape.js (graph visualization)

State Management:
├─ Zustand (light, simple)
└─ Redux Toolkit (complex app)

Form Handling:
├─ React Hook Form
└─ Formik

Animation:
├─ Framer Motion
└─ GSAP (advanced)
```

---

## 🎨 Design System Export

### Figma/Sketch Files Structure
```
📁 Design Files
├─ 🎨 01_Design_Tokens
│   ├─ Colors
│   ├─ Typography
│   └─ Spacing
├─ 🧩 02_Components
│   ├─ Buttons
│   ├─ Cards
│   ├─ Forms
│   └─ Modals
├─ 📱 03_Screens
│   ├─ Desktop_Home
│   ├─ Desktop_Detail
│   ├─ Mobile_Home
│   └─ Mobile_Detail
└─ 🔄 04_Flows
    ├─ Add_Person_Flow
    ├─ Search_Flow
    └─ Edit_Flow
```

---

## ✅ Checklist Before Launch

### Design
- [ ] Responsive trên tất cả devices
- [ ] Accessibility compliance (WCAG 2.1 AA)
- [ ] Dark mode (optional)
- [ ] Print-friendly view
- [ ] Loading states cho tất cả actions

### Development
- [ ] API error handling
- [ ] Form validation
- [ ] Image optimization
- [ ] Performance audit (<3s load)
- [ ] Cross-browser testing

### Content
- [ ] Empty states messages
- [ ] Error messages user-friendly
- [ ] Help tooltips
- [ ] Onboarding tour (optional)

---

**Version:** 1.0  
**Last Updated:** 2026-01-13  
**Design Philosophy:** Simple, Intuitive, Fast, Accessible