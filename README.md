# 📦 Inventory Management API

Sistem backend untuk mengelola stok barang dan transaksi keluar/masuk menggunakan Laravel 10.  
Frontend dapat dibangun secara terpisah menggunakan HTML, CSS, dan JavaScript murni (tanpa framework).

---

## 🚀 Fitur Utama

- ✅ Login & Logout (Sanctum Token Based)
- ✅ CRUD Barang
- ✅ CRUD Transaksi Masuk & Keluar (otomatis update stok)
- ✅ CRUD User Role `operator` (oleh admin)
- ✅ Validasi stok < 10 (stok rendah)
- ✅ Role-based access (`admin`, `operator`)
- ✅ Aman dari race condition (pakai `lockForUpdate()`)

---

## ⚙️ Instalasi

### 1. Clone Project

```bash
git clone https://github.com/namamu/inventory-api.git
cd inventory-api

2. Install Dependency
bash
Copy code
composer install
cp .env.example .env
php artisan key:generate
3. Setup Database
Buat database baru di MySQL, lalu isi konfigurasi .env:

makefile
Copy code
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=
Lalu jalankan:

bash
Copy code
php artisan migrate --seed
Seeder akan membuat:

Admin default:
username: admin
password: password

Operator default:
username: operator
password: password

4. Jalankan Server
bash
Copy code
php artisan serve
Akses API di:
📍 http://localhost:8000/api

🔐 Autentikasi
Login
POST /api/login

json
Copy code
{
  "username": "admin",
  "password": "password"
}
Response:

json
Copy code
{
  "token": "your_sanctum_token"
}
Gunakan token ini di header:

makefile
Copy code
Authorization: Bearer your_sanctum_token
Logout
POST /api/logout

🧭 Struktur Endpoint API
📦 Barang (/api/barangs)
GET – List barang

POST – Tambah barang

PUT /{id} – Edit barang

DELETE /{id} – Hapus barang

Response menyertakan status stok: "status_stok": "Stok Rendah" / "Aman"

🔄 Transaksi (/api/transaksis)
GET – List transaksi

POST – Tambah transaksi masuk / keluar

DELETE /{id} – Hapus transaksi

Validasi: transaksi keluar hanya jika stok ≥ jumlah dan tidak kurang dari 10

Contoh:

json
Copy code
{
  "barang_id": 1,
  "tanggal": "2025-06-24",
  "tipe_transaksi": "keluar",
  "jumlah": 2
}
👤 User (/api/users) – hanya admin
GET – List operator

POST – Tambah operator

PUT /{id} – Edit

DELETE /{id} – Hapus

👮 Role Akses
Endpoint	Admin	Operator
/api/barangs	✅	✅
/api/transaksis	✅	✅
/api/users	✅	❌

🌐 Konsumsi API oleh Frontend (HTML/CSS/JS)
Gunakan AJAX Fetch API dari frontend:

js
Copy code
fetch('http://localhost:8000/api/barangs', {
  method: 'GET',
  headers: {
    'Authorization': 'Bearer YOUR_TOKEN'
  }
})
.then(res => res.json())
.then(data => console.log(data));
🧪 Tes Kinerja (Opsional)
Gunakan Grafana K6 untuk stress test:

bash
Copy code
k6 run transaksi-test.js


