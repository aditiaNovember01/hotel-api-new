# 📚 Dokumentasi API Hotel

## 🔗 Base URL

```
http://localhost:8000/api
```

## 📋 Daftar Endpoint

### 👥 **User Management**

#### 1. **GET /api/users**

Menampilkan daftar semua pengguna

```bash
curl -X GET http://localhost:8000/api/users
```

**Response:**

```json
{
    "status": "berhasil",
    "message": "Daftar pengguna berhasil diambil",
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "081234567890",
            "role": "user",
            "created_at": "2025-07-27T07:00:00.000000Z",
            "updated_at": "2025-07-27T07:00:00.000000Z"
        }
    ]
}
```

#### 2. **POST /api/users**

Membuat pengguna baru

```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "password123",
    "phone": "081234567891",
    "role": "user"
  }'
```

**Request Body:**

```json
{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "password123",
    "phone": "081234567891",
    "role": "user"
}
```

#### 3. **GET /api/users/{id}**

Menampilkan detail pengguna

```bash
curl -X GET http://localhost:8000/api/users/1
```

#### 4. **PUT /api/users/{id}**

Mengupdate data pengguna

```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "phone": "081234567892"
  }'
```

#### 5. **DELETE /api/users/{id}**

Menghapus pengguna

```bash
curl -X DELETE http://localhost:8000/api/users/1
```

---

### 🏨 **Room Management**

#### 1. **GET /api/rooms**

Menampilkan daftar semua kamar

```bash
curl -X GET http://localhost:8000/api/rooms
```

#### 2. **POST /api/rooms**

Membuat kamar baru

```bash
curl -X POST http://localhost:8000/api/rooms \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Deluxe Room",
    "description": "Kamar mewah dengan pemandangan kota",
    "price_per_night": 500000,
    "max_guest": 2,
    "image_url": "https://example.com/deluxe-room.jpg"
  }'
```

#### 3. **GET /api/rooms/{id}**

Menampilkan detail kamar

```bash
curl -X GET http://localhost:8000/api/rooms/1
```

#### 4. **PUT /api/rooms/{id}**

Mengupdate data kamar

```bash
curl -X PUT http://localhost:8000/api/rooms/1 \
  -H "Content-Type: application/json" \
  -d '{
    "price_per_night": 550000
  }'
```

#### 5. **DELETE /api/rooms/{id}**

Menghapus kamar

```bash
curl -X DELETE http://localhost:8000/api/rooms/1
```

#### 6. **GET /api/rooms/search**

Mencari kamar berdasarkan kriteria

```bash
curl -X GET "http://localhost:8000/api/rooms/search?name=Deluxe&min_price=400000&max_price=600000&max_guest=2"
```

**Query Parameters:**

-   `name` - Nama kamar (optional)
-   `min_price` - Harga minimum (optional)
-   `max_price` - Harga maksimum (optional)
-   `max_guest` - Kapasitas tamu minimum (optional)

---

### 📅 **Booking Management**

#### 1. **GET /api/bookings**

Menampilkan daftar semua pemesanan

```bash
curl -X GET http://localhost:8000/api/bookings
```

#### 2. **POST /api/bookings**

Membuat pemesanan baru

```bash
curl -X POST http://localhost:8000/api/bookings \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "room_id": 1,
    "check_in_date": "2025-08-01",
    "check_out_date": "2025-08-03",
    "total_price": 1000000,
    "status": "pending"
  }'
```

#### 3. **GET /api/bookings/{id}**

Menampilkan detail pemesanan

```bash
curl -X GET http://localhost:8000/api/bookings/1
```

#### 4. **PUT /api/bookings/{id}**

Mengupdate status pemesanan

```bash
curl -X PUT http://localhost:8000/api/bookings/1 \
  -H "Content-Type: application/json" \
  -d '{
    "status": "confirmed"
  }'
```

#### 5. **DELETE /api/bookings/{id}**

Menghapus pemesanan

```bash
curl -X DELETE http://localhost:8000/api/bookings/1
```

#### 6. **GET /api/bookings/user/{userId}**

Menampilkan pemesanan berdasarkan pengguna

```bash
curl -X GET http://localhost:8000/api/bookings/user/1
```

#### 7. **POST /api/bookings/check-availability**

Cek ketersediaan kamar

```bash
curl -X POST http://localhost:8000/api/bookings/check-availability \
  -H "Content-Type: application/json" \
  -d '{
    "room_id": 1,
    "check_in_date": "2025-08-01",
    "check_out_date": "2025-08-03"
  }'
```

**Response:**

```json
{
    "status": "berhasil",
    "message": "Cek ketersediaan berhasil",
    "data": {
        "available": true,
        "room_id": 1,
        "check_in_date": "2025-08-01",
        "check_out_date": "2025-08-03"
    }
}
```

---

### 💳 **Payment Management**

#### 1. **GET /api/payments**

Menampilkan daftar semua pembayaran

```bash
curl -X GET http://localhost:8000/api/payments
```

#### 2. **POST /api/payments**

Membuat pembayaran baru

```bash
curl -X POST http://localhost:8000/api/payments \
  -H "Content-Type: application/json" \
  -d '{
    "booking_id": 1,
    "payment_method": "bank_transfer",
    "payment_status": "pending",
    "total_paid": 1000000
  }'
```

#### 3. **GET /api/payments/{id}**

Menampilkan detail pembayaran

```bash
curl -X GET http://localhost:8000/api/payments/1
```

#### 4. **PUT /api/payments/{id}**

Mengupdate status pembayaran

```bash
curl -X PUT http://localhost:8000/api/payments/1 \
  -H "Content-Type: application/json" \
  -d '{
    "payment_status": "paid",
    "total_paid": 1000000
  }'
```

#### 5. **DELETE /api/payments/{id}**

Menghapus pembayaran

```bash
curl -X DELETE http://localhost:8000/api/payments/1
```

#### 6. **GET /api/payments/booking/{bookingId}**

Menampilkan pembayaran berdasarkan pemesanan

```bash
curl -X GET http://localhost:8000/api/payments/booking/1
```

#### 7. **POST /api/payments/{id}/process**

Proses pembayaran

```bash
curl -X POST http://localhost:8000/api/payments/1/process \
  -H "Content-Type: application/json" \
  -d '{
    "total_paid": 1000000
  }'
```

#### 8. **GET /api/payments/statistics**

Menampilkan statistik pembayaran

```bash
curl -X GET http://localhost:8000/api/payments/statistics
```

**Response:**

```json
{
    "status": "berhasil",
    "message": "Statistik pembayaran berhasil diambil",
    "data": {
        "total_payments": 10,
        "paid_payments": 8,
        "pending_payments": 1,
        "failed_payments": 1,
        "total_revenue": 8000000,
        "success_rate": 80.0
    }
}
```

---

## 🔧 **Status Codes**

-   `200` - Success
-   `201` - Created
-   `400` - Bad Request
-   `404` - Not Found
-   `422` - Validation Error

## 📝 **Response Format**

Semua response mengikuti format:

```json
{
    "status": "berhasil|gagal",
    "message": "Pesan dalam bahasa Indonesia",
    "data": {}
}
```

## ⚠️ **Error Response**

```json
{
    "status": "gagal",
    "message": "Pesan error dalam bahasa Indonesia"
}
```

## 🚀 **Cara Menjalankan**

1. Jalankan migration:

```bash
php artisan migrate
```

2. Jalankan server:

```bash
php artisan serve
```

3. Akses API di: `http://localhost:8000/api`
