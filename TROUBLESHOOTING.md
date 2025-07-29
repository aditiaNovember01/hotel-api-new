# Troubleshooting Guide

## Error yang Sudah Diperbaiki

### 1. Route [password.request] not defined
**Masalah:** Link "Lupa password" di halaman login menyebabkan error karena route tidak terdefinisi.

**Solusi:** ✅ Sudah diperbaiki dengan menghapus link tersebut dari `resources/views/auth/login.blade.php`

## Cara Testing Sistem Authentication

### 1. Test Login
```bash
# Akses halaman login
http://127.0.0.1:8000/login

# Kredensial untuk testing:
Email: admin@hotel.com
Password: password
```

### 2. Test Register
```bash
# Akses halaman register
http://127.0.0.1:8000/register

# Isi form dengan data baru
```

### 3. Test Logout
```bash
# Setelah login, klik user menu di top navbar
# Pilih "Logout"
```

## Perintah untuk Clear Cache

Jika ada masalah dengan routes atau config:

```bash
# Clear semua cache
php artisan optimize:clear

# Clear route cache
php artisan route:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear
```

## Perintah untuk Database

```bash
# Migrate database
php artisan migrate

# Seed database dengan user default
php artisan db:seed --class=AdminSeeder

# Reset database (hati-hati!)
php artisan migrate:fresh --seed
```

## User Default untuk Testing

### Admin Users
1. **Email:** `admin@hotel.com`
   **Password:** `password`
   **Role:** `admin`

2. **Email:** `manager@hotel.com`
   **Password:** `password`
   **Role:** `admin`

### Regular User
3. **Email:** `john@example.com`
   **Password:** `password`
   **Role:** `user`

## Common Issues & Solutions

### 1. "Class Auth not found"
**Solusi:** Pastikan `use Illuminate\Support\Facades\Auth;` sudah di-import di controller.

### 2. "Route not found"
**Solusi:** 
- Clear route cache: `php artisan route:clear`
- Periksa file `routes/web.php`
- Pastikan route name sudah benar

### 3. "Session not working"
**Solusi:**
- Periksa file `.env` untuk session driver
- Pastikan storage permissions sudah benar
- Clear config cache: `php artisan config:clear`

### 4. "Remember me not working"
**Solusi:**
- Pastikan `remember_token` column ada di users table
- Periksa session configuration

### 5. "Middleware guest not found"
**Solusi:**
- Periksa file `bootstrap/app.php`
- Pastikan middleware guest sudah terdaftar

## File yang Penting

### Authentication Files
- `app/Http/Controllers/AuthController.php` - Controller untuk login/register
- `resources/views/auth/login.blade.php` - Halaman login
- `resources/views/auth/register.blade.php` - Halaman register
- `routes/web.php` - Routes authentication
- `app/Http/Middleware/Authenticate.php` - Middleware auth
- `app/Http/Middleware/RedirectIfAuthenticated.php` - Middleware guest

### Configuration Files
- `config/adminlte.php` - Konfigurasi AdminLTE
- `bootstrap/app.php` - Middleware registration

## Testing Checklist

- [ ] Halaman login bisa diakses
- [ ] Halaman register bisa diakses
- [ ] Login dengan kredensial yang salah menampilkan error
- [ ] Login dengan kredensial yang benar berhasil
- [ ] Register dengan data valid berhasil
- [ ] Register dengan email yang sudah ada menampilkan error
- [ ] Logout berfungsi dan redirect ke login
- [ ] User yang sudah login tidak bisa akses login/register
- [ ] User yang belum login tidak bisa akses dashboard
- [ ] User menu di AdminLTE menampilkan nama user
- [ ] Logout dari user menu berfungsi

## Debug Commands

```bash
# Lihat semua routes
php artisan route:list

# Lihat environment
php artisan env

# Test database connection
php artisan tinker
# Lalu ketik: DB::connection()->getPdo();
```

## Contact Support

Jika masih ada masalah, periksa:
1. Laravel version: `php artisan --version`
2. PHP version: `php --version`
3. Database connection
4. File permissions
5. Cache status 