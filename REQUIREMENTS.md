# Yêu cầu hệ thống (System Requirements)

## Server
- **PHP**: >= 8.2
- **Composer**: Phiên bản mới nhất
- **Web Server**: Nginx hoặc Apache
- **Database**: 
  - SQLite (Mặc định dev)
  - MySQL 5.7+ hoặc MariaDB 10.3+ (Khuyên dùng cho Production)

## PHP Extensions
Các extension bắt buộc cho Laravel 11:
- `bcmath`
- `ctype`
- `fileinfo`
- `json`
- `mbstring`
- `openssl`
- `pdo`
- `tokenizer`
- `xml`

## Client / Development
- **Node.js**: >= 18.0 (Để compile assets với Vite)
- **NPM** hoặc **Yarn**

## Cài đặt & Chạy
1. Cài đặt dependencies PHP:
   ```bash
   composer install
   ```
2. Cài đặt dependencies JS:
   ```bash
   npm install
   ```
3. Copy .env:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Chạy server (Dev):
   ```bash
   php artisan serve
   npm run dev
   ```
