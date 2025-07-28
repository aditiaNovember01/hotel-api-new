# 🔐 Dokumentasi API Autentikasi Hotel

## 🔗 Base URL

```
http://localhost:8000/api
```

## 📋 Daftar Endpoint Autentikasi

### 🔓 **Public Routes (Tidak Perlu Login)**

#### 1. **POST /api/auth/register**

Mendaftarkan pengguna baru

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "081234567890",
    "role": "user"
  }'
```

**Request Body:**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "081234567890",
    "role": "user"
}
```

**Response Success (201):**

```json
{
    "status": "berhasil",
    "message": "Registrasi berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "081234567890",
            "role": "user",
            "created_at": "2025-07-27T07:43:23.000000Z",
            "updated_at": "2025-07-27T07:43:23.000000Z"
        },
        "token": "1|abcdef1234567890...",
        "token_type": "Bearer"
    }
}
```

#### 2. **POST /api/auth/login**

Login pengguna

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Request Body:**

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response Success (200):**

```json
{
    "status": "berhasil",
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "081234567890",
            "role": "user",
            "created_at": "2025-07-27T07:43:23.000000Z",
            "updated_at": "2025-07-27T07:43:23.000000Z"
        },
        "token": "2|xyz789abcdef...",
        "token_type": "Bearer"
    }
}
```

**Response Error (422):**

```json
{
    "message": "The provided credentials are incorrect.",
    "errors": {
        "email": ["Email atau password salah"]
    }
}
```

---

### 🔒 **Protected Routes (Perlu Login)**

**Header yang diperlukan untuk semua protected routes:**

```bash
Authorization: Bearer YOUR_TOKEN_HERE
```

#### 3. **POST /api/auth/logout**

Logout pengguna

```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response Success (200):**

```json
{
    "status": "berhasil",
    "message": "Logout berhasil"
}
```

#### 4. **GET /api/auth/me**

Mendapatkan data user yang sedang login

```bash
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response Success (200):**

```json
{
    "status": "berhasil",
    "message": "Data user berhasil diambil",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "081234567890",
        "role": "user",
        "created_at": "2025-07-27T07:43:23.000000Z",
        "updated_at": "2025-07-27T07:43:23.000000Z"
    }
}
```

#### 5. **POST /api/auth/refresh**

Refresh token

```bash
curl -X POST http://localhost:8000/api/auth/refresh \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response Success (200):**

```json
{
    "status": "berhasil",
    "message": "Token berhasil diperbarui",
    "data": {
        "token": "3|newtoken123...",
        "token_type": "Bearer"
    }
}
```

#### 6. **PUT /api/auth/profile**

Update profil user

```bash
curl -X PUT http://localhost:8000/api/auth/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Smith",
    "phone": "081234567891"
  }'
```

**Request Body:**

```json
{
    "name": "John Smith",
    "phone": "081234567891"
}
```

**Response Success (200):**

```json
{
    "status": "berhasil",
    "message": "Profil berhasil diupdate",
    "data": {
        "id": 1,
        "name": "John Smith",
        "email": "john@example.com",
        "phone": "081234567891",
        "role": "user",
        "created_at": "2025-07-27T07:43:23.000000Z",
        "updated_at": "2025-07-27T07:44:15.000000Z"
    }
}
```

#### 7. **PUT /api/auth/change-password**

Ganti password

```bash
curl -X PUT http://localhost:8000/api/auth/change-password \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "current_password": "password123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
  }'
```

**Request Body:**

```json
{
    "current_password": "password123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response Success (200):**

```json
{
    "status": "berhasil",
    "message": "Password berhasil diubah"
}
```

**Response Error (422):**

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "current_password": ["Password saat ini salah"]
    }
}
```

---

## 🔧 **Cara Menggunakan Token**

### 1. **Setelah Login/Register**

Setelah berhasil login atau register, Anda akan mendapatkan token. Simpan token ini untuk digunakan di request selanjutnya.

### 2. **Menggunakan Token di Request**

Tambahkan header `Authorization` dengan format `Bearer TOKEN`:

```bash
curl -X GET http://localhost:8000/api/rooms \
  -H "Authorization: Bearer 1|abcdef1234567890..."
```

### 3. **Contoh Request dengan Token**

```bash
# Lihat semua kamar (perlu login)
curl -X GET http://localhost:8000/api/rooms \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# Buat pemesanan baru (perlu login)
curl -X POST http://localhost:8000/api/bookings \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "room_id": 1,
    "check_in_date": "2025-08-01",
    "check_out_date": "2025-08-03",
    "total_price": 700000
  }'
```

---

## 📝 **Validasi dan Error Handling**

### **Validasi Register:**

-   `name`: Required, string, max 255 karakter
-   `email`: Required, email format, unique
-   `password`: Required, min 6 karakter, confirmed
-   `phone`: Optional, string, max 20 karakter
-   `role`: Optional, enum (admin, user)

### **Validasi Login:**

-   `email`: Required, email format
-   `password`: Required

### **Validasi Update Profile:**

-   `name`: Optional, string, max 255 karakter
-   `phone`: Optional, string, max 20 karakter

### **Validasi Change Password:**

-   `current_password`: Required
-   `password`: Required, min 6 karakter, confirmed

---

## 🚀 **Testing dengan Data Sample**

### **Credentials untuk Testing:**

**Admin:**

-   Email: `admin@hotel.com`
-   Password: `admin123`

**User:**

-   Email: `john@example.com`
-   Password: `password123`

### **Contoh Testing Lengkap:**

```bash
# 1. Register user baru
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "081234567890"
  }'

# 2. Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'

# 3. Gunakan token untuk akses protected routes
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer TOKEN_DARI_LOGIN"

# 4. Logout
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer TOKEN_DARI_LOGIN"
```

---

## ⚠️ **Catatan Penting**

1. **Token Expiry:** Token akan expired setelah 30 hari (default Sanctum)
2. **Single Token:** Setiap login akan menghapus token lama dan membuat token baru
3. **Security:** Jangan share token dengan siapapun
4. **HTTPS:** Gunakan HTTPS di production untuk keamanan
5. **Rate Limiting:** API memiliki rate limiting 60 requests per menit

---

## 🔒 **Protected vs Public Routes**

### **Public Routes (Tidak Perlu Token):**

-   `POST /api/auth/register`
-   `POST /api/auth/login`
-   `GET /api/rooms`
-   `GET /api/rooms/{id}`
-   `GET /api/rooms/search`

### **Protected Routes (Perlu Token):**

-   Semua routes lainnya memerlukan authentication
-   Tambahkan header `Authorization: Bearer TOKEN`

---

## 🎯 **Status Codes**

-   `200` - Success
-   `201` - Created
-   `401` - Unauthorized (Token tidak valid)
-   `422` - Validation Error
-   `500` - Server Error
