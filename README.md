# SPK-GIS AHP Smart Dinas Tenaga Kerja 
 SPK-GIS Metode AHP dan SMART <br>
 client : Tri Ulandari (UINSU)

# Requirements
- PHP >= 8.0.7
- Composer
- MySQL/MariaDB/PostgreSQL
- Laravel 8
- Google Maps API
- Online Connection for load maps

# Library dan Paket
- stevebauman/location: 6.5
- yajra/laravel-datatables-oracle: 9.19
- Bootstrap v5.1.3
- CoreUI v4.2.3
- SweetAlert v8.19.0
- jQuery v3.3.1


## Installation

### Step 1: Clone Repository
Silahkan download project dan extract project di komputer, atau gunakan git clone
```bash
git clone https://github.com/username/repo-name.git](https://github.com/satriaharum01/SPK-GIS_AHP-SMART_PUPR.git
```

### Step 2: Install Dependencies
```
composer install
```

### Step 3: Copy .env File dan Konfigurasi
Copy Environment
```bash
cp .env.example .env
```
Generate Key
```
php artisan key:generate
```

Sesuaikan `.env` file dengan pengaturan database dan konfigurasi lainnya.

### Step 4: Migrasi Database
Silahkan buat database baru dan import database menggunakan file .sql yang ada.
- DBNAME : laravel_ulan

### Step 5: Jalankan Server
```bash
php artisan serve
```

## Usage
Project ini merupakan implementasi tugas akhir dari mahasiswa, gunakan dengan bijak.<br>
user akses (password : 123456) <br>
- administrator
- pimpinan
<br>
akun <br>
admin@gmail.com <br>
pimpinan@gmail.com

## Contributing
Silahkan berikan saran untuk membantu perkembangan project lebih lanjut mengenai fitur lanjutan.
