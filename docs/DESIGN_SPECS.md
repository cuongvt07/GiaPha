# Prompt thiết kế UI/UX cho Hệ thống Quản lý Gia phả

## Tổng quan dự án
Thiết kế giao diện web quản lý gia phả với khả năng hiển thị và thao tác trực tiếp trên cây gia phả. Hệ thống sử dụng Laravel + Livewire, tập trung vào trải nghiệm single-page với canvas vô hạn.

## Yêu cầu chính

### 1. Layout tổng thể
- **Single-page application**: Toàn bộ tính năng trên 1 màn hình.
- **Canvas vô hạn**: Cho phép pan/zoom như Figma để xem cây gia phả rộng và sâu nhiều thế hệ.
- **Sidebars công cụ**: 2 bên trái/phải chứa các panel công cụ có thể đóng/mở.
- **Responsive**: Tối ưu cho desktop (ưu tiên), tablet và mobile.

### 2. Khu vực Canvas - Cây gia phả
**Tính năng tương tác:**
- Pan (kéo) canvas bằng chuột/touch.
- Zoom in/out (scroll wheel, pinch, hoặc nút +/-).
- Fit to view (zoom toàn bộ cây vào màn hình).
- Mini-map để điều hướng khi cây quá lớn.
- Grid/guidelines nhẹ để định hướng.

**Hiển thị node thành viên:**
- Card compact hiển thị: Ảnh đại diện, tên, năm sinh-mất, vai trò.
- Màu sắc phân biệt: giới tính, thế hệ, nhánh gia đình.
- Trạng thái: còn sống/đã mất, kết hôn/độc thân.
- Line/connector thể hiện quan hệ: cha-mẹ, vợ-chồng, anh-em.
- Hover effect: hiển thị thông tin tóm tắt.
- Click: mở popup/panel chi tiết.

**CRUD trực tiếp trên canvas:**
- Click vào node → inline edit hoặc popup form.
- Right-click menu: Thêm con, thêm vợ/chồng, chỉnh sửa, xóa.
- Drag & drop để sắp xếp lại vị trí (tùy chọn).
- Nút "+" floating khi hover vào node để thêm nhanh.

### 3. Sidebar trái - Navigation & Tools
**Các panel gợi ý:**
- **Search & Filter**: Tìm kiếm thành viên, lọc theo thế hệ, chi nhánh, năm sinh.
- **Tree Overview**: Danh sách phân cấp dạng tree view, click để focus vào node.
- **Statistics**: Tổng số thành viên, số thế hệ, biểu đồ phân bố.
- **Views**: Chuyển đổi layout cây (dọc/ngang/fan/circular).
- **Settings**: Cài đặt hiển thị (show/hide thông tin, màu sắc, font size).

### 4. Sidebar phải - Member Details & Actions
**Các panel gợi ý:**
- **Member Profile**: Thông tin chi tiết thành viên được chọn.
  - Ảnh, thông tin cơ bản (họ tên, ngày sinh/mất, nơi sinh).
  - Tiểu sử, học vấn, nghề nghiệp.
  - Thành tích, danh hiệu.
  - Ảnh album.
- **Relationships**: Danh sách quan hệ (cha mẹ, vợ/chồng, con cái, anh chị em).
- **Documents**: Tài liệu liên quan (giấy khai sinh, ảnh cũ, văn bản).
- **Timeline**: Dòng thời gian sự kiện đời.

**Quick Actions:**
- Add member (form nhanh).
- Edit selected member.
- Delete member (với confirmation).
- Export/Print cây gia phả.

### 5. Top Bar - Global Actions
- **Logo/Title**: Tên gia phả.
- **User account**: Menu user (profile, settings, logout).
- **Actions**:
  - Save changes (nếu có thay đổi chưa lưu).
  - Export (PDF, Excel, GEDCOM).
  - Print.
  - Share/Collaborate.
- **View controls**: Zoom controls, fit view, toggle sidebars.
- **Breadcrumb**: Hiển thị vị trí hiện tại trong cây (nếu có).

### 6. Modals/Popups
**Add/Edit Member Form:**
- Modal tập trung, form rõ ràng với validation.
- Tabs cho các nhóm thông tin: Basic Info, Biography, Photos, Documents.
- Upload ảnh drag-drop.
- Suggest relationships (autocomplete).
- Preview trước khi save.

**Confirmation dialogs:**
- Delete member (cảnh báo về ảnh hưởng).
- Discard changes.

**Media viewer:**
- Lightbox xem ảnh fullscreen.
- Gallery với navigation.

### 7. Design System
**Color Palette:**
- Primary: Màu chủ đạo cho brand (gợi ý: xanh lá truyền thống, nâu gỗ, hoặc vàng gold).
- Secondary: Màu phụ cho accents.
- Gender colors: Xanh dương (nam), hồng/đỏ nhạt (nữ).
- Status colors: Xám (đã mất), xanh lá (còn sống).
- Background: Trắng/xám nhạt cho canvas, sidebar tối màu hơn 1 chút.
- Generation colors: Gradient hoặc màu phân biệt các thế hệ.

**Typography:**
- Font family: Hỗ trợ tiếng Việt tốt (Inter, Be Vietnam Pro, Roboto).
- Hierarchy rõ ràng: H1-H6, body, caption.
- Size readable: min 14px cho text thông thường.

**Spacing & Layout:**
- Grid system: 8px base unit.
- Consistent padding/margin.
- Card design cho node với shadow nhẹ.
- Rounded corners (4-8px).

**Icons:**
- Icon set nhất quán (Heroicons, Feather, FontAwesome).
- Icons cho actions: add, edit, delete, search, filter, zoom, etc.

**Interactions:**
- Smooth animations (transitions 200-300ms).
- Loading states (skeleton screens, spinners).
- Hover states rõ ràng.
- Active/selected states.
- Disabled states với opacity reduced.

### 8. Responsive Behaviors
**Desktop (1920px+):**
- 2 sidebars hiển thị đầy đủ.
- Canvas chiếm phần lớn.
- Node size normal.

**Tablet (768-1920px):**
- Sidebars có thể collapse thành icons.
- Canvas responsive.
- Touch-friendly controls.

**Mobile (<768px):**
- Sidebars ẩn mặc định, toggle qua menu.
- Canvas full-width.
- Bottom sheet cho member details.
- Simplified node cards.

### 9. Technical Considerations cho UI
**Canvas Implementation:**
- Sử dụng SVG hoặc Canvas HTML5 cho rendering cây.
- Libraries gợi ý: D3.js, vis.js, GoJS, Cytoscape.js.
- Virtual rendering cho performance khi có nhiều node.

**Livewire Integration:**
- Real-time updates khi có thay đổi.
- Optimistic UI updates.
- Loading states cho Livewire actions.
- Wire:loading directives.

**Performance:**
- Lazy loading cho ảnh và documents.
- Pagination/infinite scroll cho danh sách lớn.
- Debounce search inputs.
- Cache tree data.

### 10. Accessibility
- Keyboard navigation (Tab, Arrow keys để di chuyển trong cây).
- Screen reader support.
- High contrast mode.
- Focus indicators rõ ràng.
- Alt text cho images.

### 11. User Experience Enhancements
**Onboarding:**
- Tutorial cho lần đầu sử dụng.
- Tooltips cho các controls.
- Empty states với hướng dẫn "Add first member".

**Feedback:**
- Toast notifications cho thành công/lỗi.
- Undo/Redo cho các thao tác quan trọng.
- Confirm before destructive actions.
- Auto-save với indicator.

**Collaboration (nếu cần):**
- Show who's viewing/editing.
- Comments/notes on members.
- Activity log.
