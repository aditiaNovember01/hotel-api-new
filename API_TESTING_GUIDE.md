# 🧪 Panduan Testing API Hotel Laravel 12

## 🚀 **Cara Menjalankan API**

### 1. **Jalankan Server**

```bash
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

### 2. **Test API Berjalan**

```bash
curl -X GET http://127.0.0.1:8000/api/test
```

**Response yang diharapkan:**

```json
{
    "status": "berhasil",
    "message": "API Hotel berjalan dengan baik",
    "timestamp": "2025-07-27T07:45:00.000000Z"
}
```

---

## 🔐 **Testing Autentikasi**

### **1. Register User Baru**

```bash
curl -X POST http://127.0.0.1:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "081234567890"
  }'
```

### **2. Login**

```bash
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

**Simpan token dari response untuk digunakan di request selanjutnya.**

### **3. Test Protected Route dengan Token**

```bash
# Ganti YOUR_TOKEN dengan token dari login
curl -X GET http://127.0.0.1:8000/api/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🏨 **Testing Room API**

### **Public Routes (Tidak Perlu Login)**

#### **1. Lihat Semua Kamar**

```bash
curl -X GET http://127.0.0.1:8000/api/rooms
```

#### **2. Lihat Detail Kamar**

```bash
curl -X GET http://127.0.0.1:8000/api/rooms/1
```

#### **3. Cari Kamar**

```bash
curl -X GET "http://127.0.0.1:8000/api/rooms/search?min_price=400000&max_price=600000"
```

### **Protected Routes (Perlu Login)**

#### **1. Tambah Kamar Baru (Admin)**

```bash
curl -X POST http://127.0.0.1:8000/api/admin/rooms \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Room",
    "description": "Kamar test untuk development",
    "price_per_night": 400000,
    "max_guest": 2,
    "image_url": "https://example.com/test-room.jpg"
  }'
```

#### **2. Update Kamar (Admin)**

```bash
curl -X PUT http://127.0.0.1:8000/api/admin/rooms/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "price_per_night": 450000
  }'
```

---

## 📅 **Testing Booking API**

### **1. Cek Ketersediaan Kamar**

```bash
curl -X POST http://127.0.0.1:8000/api/bookings/check-availability \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "room_id": 1,
    "check_in_date": "2025-08-01",
    "check_out_date": "2025-08-03"
  }'
```

### **2. Buat Pemesanan**

```bash
curl -X POST http://127.0.0.1:8000/api/bookings \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "room_id": 1,
    "check_in_date": "2025-08-01",
    "check_out_date": "2025-08-03",
    "total_price": 800000
  }'
```

### **3. Lihat Pemesanan**

```bash
curl -X GET http://127.0.0.1:8000/api/bookings \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 💳 **Testing Payment API**

### **1. Buat Pembayaran**

```bash
curl -X POST http://127.0.0.1:8000/api/payments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "booking_id": 1,
    "payment_method": "bank_transfer",
    "total_paid": 800000
  }'
```

### **2. Proses Pembayaran**

```bash
curl -X POST http://127.0.0.1:8000/api/payments/1/process \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "total_paid": 800000
  }'
```

### **3. Lihat Statistik Pembayaran**

```bash
curl -X GET http://127.0.0.1:8000/api/payments/statistics \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 👥 **Testing User API**

### **1. Lihat Semua User (Admin)**

```bash
curl -X GET http://127.0.0.1:8000/api/users \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### **2. Tambah User Baru (Admin)**

```bash
curl -X POST http://127.0.0.1:8000/api/users \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password123",
    "phone": "081234567891",
    "role": "user"
  }'
```

---

## 🔧 **Testing dengan Postman**

### **1. Setup Collection**

1. Buat collection baru di Postman
2. Set base URL: `http://127.0.0.1:8000/api`

### **2. Environment Variables**

Buat environment dengan variables:

-   `base_url`: `http://127.0.0.1:8000/api`
-   `token`: (akan diisi setelah login)

### **3. Contoh Request di Postman**

#### **Login Request:**

-   Method: `POST`
-   URL: `{{base_url}}/auth/login`
-   Headers: `Content-Type: application/json`
-   Body (raw JSON):

```json
{
    "email": "test@example.com",
    "password": "password123"
}
```

#### **Get Rooms Request:**

-   Method: `GET`
-   URL: `{{base_url}}/rooms`
-   Headers: `Authorization: Bearer {{token}}`

---

## ⚠️ **Troubleshooting**

### **Error 500 - Route not defined**

-   Pastikan server Laravel berjalan
-   Cek apakah ada error di log: `storage/logs/laravel.log`

### **Error 401 - Unauthorized**

-   Pastikan token valid dan tidak expired
-   Cek format header: `Authorization: Bearer TOKEN`

### **Error 422 - Validation Error**

-   Cek format JSON request body
-   Pastikan semua field required terisi

### **Error 404 - Not Found**

-   Cek URL endpoint
-   Pastikan route terdaftar: `php artisan route:list --path=api`

---

## 📋 **Checklist Testing**

-   [ ] Server Laravel berjalan
-   [ ] API test endpoint berhasil
-   [ ] Register user berhasil
-   [ ] Login berhasil dan dapat token
-   [ ] Protected routes bisa diakses dengan token
-   [ ] Public routes bisa diakses tanpa token
-   [ ] CRUD operations berfungsi
-   [ ] Error handling berfungsi

---

## 🎯 **Quick Test Commands**

```bash
# 1. Test API berjalan
curl -X GET http://127.0.0.1:8000/api/test

# 2. Register user
curl -X POST http://127.0.0.1:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@test.com","password":"123456","password_confirmation":"123456"}'

# 3. Login dan dapat token
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@test.com","password":"123456"}'

# 4. Test protected route
curl -X GET http://127.0.0.1:8000/api/auth/me \
  -H "Authorization: Bearer TOKEN_DARI_LOGIN"
```
