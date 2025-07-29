# Sistem Authentication Hotel Management

## Fitur Authentication

### 1. Login
- **URL:** `/login`
- **Method:** GET (form) dan POST (submit)
- **Fitur:**
  - Form login dengan email dan password
  - Validasi input dengan pesan error dalam bahasa Indonesia
  - Remember me checkbox
  - Redirect ke dashboard setelah login berhasil
  - Pesan error jika email/password salah

### 2. Register
- **URL:** `/register`
- **Method:** GET (form) dan POST (submit)
- **Fitur:**
  - Form registrasi dengan nama, email, password, dan konfirmasi password
  - Validasi input dengan pesan error dalam bahasa Indonesia
  - Checkbox persetujuan syarat dan ketentuan
  - Auto login setelah registrasi berhasil
  - Redirect ke dashboard setelah registrasi

### 3. Logout
- **URL:** `/logout`
- **Method:** POST
- **Fitur:**
  - Logout user dan invalidate session
  - Redirect ke halaman login
  - Pesan sukses logout

## Controller

### AuthController
```php
// Methods:
- showLogin()     // Menampilkan form login
- showRegister()  // Menampilkan form register
- login()         // Proses login
- register()      // Proses register
- logout()        // Proses logout
```

## Routes

```php
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (memerlukan login)
Route::middleware(['auth'])->group(function () {
    // Semua routes dashboard
});
```

## Middleware

### 1. Authenticate Middleware
- **File:** `app/Http/Middleware/Authenticate.php`
- **Fungsi:** Redirect user yang belum login ke halaman login
- **Redirect:** `/login`

### 2. RedirectIfAuthenticated Middleware
- **File:** `app/Http/Middleware/RedirectIfAuthenticated.php`
- **Fungsi:** Redirect user yang sudah login ke dashboard
- **Redirect:** `/`

## Views

### 1. Login Page (`resources/views/auth/login.blade.php`)
- **Design:** AdminLTE login page
- **Fitur:**
  - Form login dengan icon
  - Validasi error display
  - Remember me checkbox
  - Link ke register dan lupa password
  - Responsive design

### 2. Register Page (`resources/views/auth/register.blade.php`)
- **Design:** AdminLTE register page
- **Fitur:**
  - Form register dengan icon
  - Validasi error display
  - Terms and conditions checkbox
  - Link ke login page
  - Responsive design

## User Default

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

## AdminLTE Integration

### User Menu
- **Location:** Top navbar (kanan)
- **Fitur:**
  - Profile link
  - Settings link
  - Logout button dengan form tersembunyi

### Logout Form
- **Location:** Welcome page (`resources/views/welcome.blade.php`)
- **Method:** POST dengan CSRF token
- **Hidden form** untuk logout dari user menu

## Security Features

### 1. CSRF Protection
- Semua form menggunakan `@csrf` token
- Laravel CSRF middleware aktif

### 2. Password Hashing
- Password di-hash menggunakan `Hash::make()`
- Verifikasi password menggunakan `Auth::attempt()`

### 3. Session Security
- Session regeneration setelah login
- Session invalidation setelah logout
- Remember me functionality

### 4. Input Validation
- Server-side validation dengan pesan error custom
- Client-side validation dengan HTML5 attributes
- XSS protection dengan Laravel's built-in features

## Error Handling

### Login Errors
- Email tidak valid
- Password minimal 6 karakter
- Email atau password salah

### Register Errors
- Nama wajib diisi
- Email wajib diisi dan unik
- Password minimal 6 karakter
- Konfirmasi password tidak cocok

## Styling

### AdminLTE Theme
- **Login Page:** `hold-transition login-page`
- **Register Page:** `hold-transition register-page`
- **Icons:** Font Awesome icons
- **Colors:** Primary theme colors
- **Responsive:** Mobile-friendly design

## Testing

### Manual Testing
1. **Login Test:**
   - Coba login dengan kredensial yang salah
   - Coba login dengan kredensial yang benar
   - Test remember me functionality

2. **Register Test:**
   - Coba register dengan data yang tidak valid
   - Coba register dengan email yang sudah ada
   - Coba register dengan data yang valid

3. **Logout Test:**
   - Login, lalu logout
   - Pastikan redirect ke login page

### Automated Testing
```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter AuthTest
```

## Deployment Notes

### Environment Variables
Pastikan file `.env` sudah dikonfigurasi dengan benar:
```env
APP_NAME="Hotel Management System"
APP_URL=http://localhost:8000
SESSION_DRIVER=file
```

### Database
Pastikan database sudah di-migrate dan di-seed:
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

## Troubleshooting

### Common Issues

1. **"Class Auth not found"**
   - Pastikan `use Illuminate\Support\Facades\Auth;` sudah di-import

2. **"Route not found"**
   - Pastikan routes sudah didefinisikan dengan benar
   - Clear route cache: `php artisan route:clear`

3. **"Session not working"**
   - Pastikan session driver sudah dikonfigurasi
   - Check storage permissions

4. **"Remember me not working"**
   - Pastikan `remember_token` column ada di users table
   - Check session configuration 