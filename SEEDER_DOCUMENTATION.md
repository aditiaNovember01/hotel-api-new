# 🌱 Dokumentasi Seeder Hotel API

## 📋 Daftar Seeder

### 1. **UserSeeder** (`database/seeders/UserSeeder.php`)

Seeder untuk data pengguna dengan berbagai role.

**Data yang dibuat:**

-   **2 Admin:**
    -   `admin@hotel.com` / `admin123` (Admin Hotel)
    -   `manager@hotel.com` / `manager123` (Manager Hotel)
-   **6 Users:**
    -   `john@example.com` / `password123` (John Doe)
    -   `jane@example.com` / `password123` (Jane Smith)
    -   `bob@example.com` / `password123` (Bob Wilson)
    -   `alice@example.com` / `password123` (Alice Brown)
    -   `charlie@example.com` / `password123` (Charlie Davis)
    -   `diana@example.com` / `password123` (Diana Miller)

### 2. **RoomSeeder** (`database/seeders/RoomSeeder.php`)

Seeder untuk data kamar hotel dengan berbagai tipe dan fasilitas.

**Data yang dibuat (12 kamar):**

| Nama Kamar         | Harga/Malam  | Kapasitas | Deskripsi                                          |
| ------------------ | ------------ | --------- | -------------------------------------------------- |
| Standard Room      | Rp 350.000   | 2 orang   | Kamar standar dengan queen bed, AC, TV LED         |
| Deluxe Room        | Rp 550.000   | 2 orang   | Kamar mewah dengan king bed, mini bar, balkon      |
| Superior Room      | Rp 450.000   | 3 orang   | Kamar superior dengan king bed, sofa bed, bathtub  |
| Executive Suite    | Rp 850.000   | 2 orang   | Suite dengan ruang tamu, jacuzzi, pemandangan kota |
| Family Room        | Rp 650.000   | 4 orang   | Kamar keluarga dengan 2 queen bed, sofa bed        |
| Presidential Suite | Rp 2.500.000 | 4 orang   | Suite mewah dengan 2 kamar, sauna pribadi          |
| Honeymoon Suite    | Rp 1.200.000 | 2 orang   | Suite romantis dengan dekorasi khusus              |
| Business Suite     | Rp 750.000   | 2 orang   | Suite bisnis dengan ruang kerja lengkap            |
| Garden View Room   | Rp 400.000   | 2 orang   | Kamar dengan pemandangan taman                     |
| Pool View Room     | Rp 500.000   | 2 orang   | Kamar dengan pemandangan kolam renang              |
| Accessible Room    | Rp 350.000   | 2 orang   | Kamar khusus untuk kebutuhan khusus                |
| Connecting Rooms   | Rp 800.000   | 4 orang   | Dua kamar yang terhubung                           |

### 3. **BookingSeeder** (`database/seeders/BookingSeeder.php`)

Seeder untuk data pemesanan dengan berbagai status dan tanggal.

**Data yang dibuat (10 pemesanan):**

-   **Confirmed Bookings:** 4 pemesanan dengan status 'confirmed'
-   **Pending Bookings:** 5 pemesanan dengan status 'pending'
-   **Cancelled Bookings:** 1 pemesanan dengan status 'cancelled'

**Rentang tanggal:** 1-38 hari ke depan
**Total nilai:** Rp 15.000.000+

### 4. **PaymentSeeder** (`database/seeders/PaymentSeeder.php`)

Seeder untuk data pembayaran dengan berbagai metode dan status.

**Data yang dibuat:**

-   **Paid Payments:** 4 pembayaran dengan status 'paid'
-   **Pending Payments:** 3 pembayaran dengan status 'pending'
-   **Failed Payments:** 1 pembayaran dengan status 'failed'

**Metode pembayaran:**

-   Bank Transfer
-   Credit Card
-   E-Wallet

## 🚀 Cara Menjalankan Seeder

### 1. **Jalankan semua seeder sekaligus:**

```bash
php artisan db:seed
```

### 2. **Jalankan seeder tertentu:**

```bash
# Jalankan UserSeeder saja
php artisan db:seed --class=UserSeeder

# Jalankan RoomSeeder saja
php artisan db:seed --class=RoomSeeder

# Jalankan BookingSeeder saja
php artisan db:seed --class=BookingSeeder

# Jalankan PaymentSeeder saja
php artisan db:seed --class=PaymentSeeder
```

### 3. **Reset database dan jalankan seeder:**

```bash
php artisan migrate:fresh --seed
```

## 📊 Data Sample yang Dihasilkan

Setelah menjalankan seeder, Anda akan memiliki:

### 👥 **Users:**

-   **8 pengguna** (2 admin + 6 user)
-   **Credentials untuk testing:**
    -   Admin: `admin@hotel.com` / `admin123`
    -   User: `john@example.com` / `password123`

### 🏨 **Rooms:**

-   **12 kamar** dengan berbagai tipe dan harga
-   **Range harga:** Rp 350.000 - Rp 2.500.000/malam
-   **Kapasitas:** 2-4 orang per kamar

### 📅 **Bookings:**

-   **10 pemesanan** dengan berbagai status
-   **Tanggal check-in:** 1-38 hari ke depan
-   **Total nilai:** Rp 15.000.000+

### 💳 **Payments:**

-   **8 pembayaran** dengan berbagai status
-   **Metode pembayaran:** Bank Transfer, Credit Card, E-Wallet
-   **Status:** Paid, Pending, Failed

## 🔧 Testing API dengan Data Sample

### 1. **Test User API:**

```bash
# Login sebagai admin
curl -X GET http://localhost:8000/api/users

# Login sebagai user
curl -X GET http://localhost:8000/api/users/1
```

### 2. **Test Room API:**

```bash
# Lihat semua kamar
curl -X GET http://localhost:8000/api/rooms

# Cari kamar berdasarkan harga
curl -X GET "http://localhost:8000/api/rooms/search?min_price=400000&max_price=600000"
```

### 3. **Test Booking API:**

```bash
# Lihat semua pemesanan
curl -X GET http://localhost:8000/api/bookings

# Lihat pemesanan user tertentu
curl -X GET http://localhost:8000/api/bookings/user/3

# Cek ketersediaan kamar
curl -X POST http://localhost:8000/api/bookings/check-availability \
  -H "Content-Type: application/json" \
  -d '{
    "room_id": 1,
    "check_in_date": "2025-08-01",
    "check_out_date": "2025-08-03"
  }'
```

### 4. **Test Payment API:**

```bash
# Lihat semua pembayaran
curl -X GET http://localhost:8000/api/payments

# Lihat statistik pembayaran
curl -X GET http://localhost:8000/api/payments/statistics

# Lihat pembayaran untuk booking tertentu
curl -X GET http://localhost:8000/api/payments/booking/1
```

## ⚠️ **Catatan Penting**

1. **Urutan Seeder:** UserSeeder → RoomSeeder → BookingSeeder → PaymentSeeder
2. **Dependencies:** BookingSeeder membutuhkan User dan Room, PaymentSeeder membutuhkan Booking
3. **Data Realistis:** Semua data dibuat dengan skenario yang realistis
4. **Testing Ready:** Data siap untuk testing API endpoints

## 🎯 **Manfaat Data Sample**

-   ✅ **Testing API** dengan data yang realistis
-   ✅ **Demo aplikasi** dengan data yang lengkap
-   ✅ **Development** tanpa perlu input manual
-   ✅ **Presentation** dengan data yang menarik
-   ✅ **Documentation** dengan contoh yang jelas
