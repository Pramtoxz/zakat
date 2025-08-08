# 🕌 Sistem Manajemen Zakat - MPZ Alumni FK Unand Padang

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.0+-EF4223?style=flat&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)

Sistem manajemen zakat digital untuk **Lembaga Mitra Pengelola Zakat (MPZ) Alumni FK Unand Padang**. Aplikasi ini dirancang untuk mengelola zakat, infaq, dan sedekah secara profesional, transparan, dan akuntabel.

## 🎯 Tentang Aplikasi

**Lembaga Mitra Pengelola Zakat (MPZ) Alumni FK Unand Padang** hadir untuk mewujudkan keadilan sosial melalui pendistribusian zakat yang tepat sasaran.

### Visi & Misi
- **Visi**: Menjadi lembaga pengelola zakat terpercaya yang berkontribusi dalam mengentaskan kemiskinan dan membangun masyarakat sejahtera di Sumatera Barat
- **Misi**: Mengelola zakat, infaq, dan sedekah secara profesional, transparan, dan akuntabel untuk kesejahteraan umat

## ✨ Fitur Utama

### 🏠 Public Features
- **Landing Page Modern** dengan informasi lengkap MPZ
- **Kalkulator Zakat** untuk berbagai kategori zakat
- **Program Showcase** untuk program urgent dan regular
- **Informasi Organisasi** lengkap

### 👥 User Management
- **Multi-Role System**: Admin, Program, Keuangan, Ketua, Donatur, Mustahik
- **OTP Authentication** untuk register dan reset password
- **Profile Management** untuk donatur dan mustahik
- **Session Security** yang terjamin

### 💰 Financial Management
- **Zakat Management**: Pencatatan dan verifikasi zakat
- **Donasi Management**: Pengelolaan donasi
- **Penyaluran Management**: Distribusi dana kepada mustahik
- **Financial Reporting**: Laporan keuangan komprehensif
- **Real-time Balance**: Monitor saldo dana

### 📋 Program Management
- **Kategori Program**: Pengelolaan kategori bantuan
- **Program Management**: Kelola program urgent dan regular
- **Permohonan System**: Sistem pengajuan bantuan
- **Status Tracking**: Pelacakan status permohonan

### 📊 Dashboard & Reporting
- **Role-based Dashboard**: Dashboard khusus per role
- **Real-time Statistics**: Statistik dana dan aktivitas
- **Comprehensive Reports**: Laporan lengkap semua modul
- **Data Visualization**: Grafik dan chart analisis

## 🛠 Teknologi

### Backend
- **Framework**: CodeIgniter 4.0+
- **PHP**: 8.1+
- **Database**: MySQL
- **Authentication**: Custom OTP-based

### Frontend
- **CSS**: Tailwind CSS
- **Icons**: Font Awesome 6.0
- **JavaScript**: Alpine.js
- **Dashboard**: AdminLTE 3.x

### Dependencies
- **DataTables**: hermawan/codeigniter4-datatables
- **Testing**: PHPUnit ^10.5.16

## 🚀 Instalasi

### Requirements
- PHP 8.2+
- MySQL 5.7+
- Laragon
- Composer

### Quick Start
```bash
# Clone repository
git clone https://github.com/your-repo/zakat-mpz.git
cd zakat-mpz

# Install dependencies
composer install

# Setup environment
cp env .env
# Edit .env sesuai konfigurasi

# Setup database
php spark migrate
php spark db:seed DatabaseSeeder

# Set permissions
chmod -R 755 writable/
chmod -R 755 public/uploads/

# Start server
php spark serve
```

## ⚙️ Konfigurasi

### Database (.env)
```env
database.default.hostname = localhost
database.default.database = zakat_mpz
database.default.username = your_username
database.default.password = your_password
```

### Email untuk OTP (.env)
```env
email.SMTPHost = smtp.gmail.com
email.SMTPUser = your-email@gmail.com
email.SMTPPass = your-app-password
email.SMTPPort = 587
```

## 🗄️ Struktur Database

### Tabel Utama
- **users**: Data pengguna dengan multi-role
- **donatur**: Profil lengkap donatur
- **mustahik**: Profil lengkap penerima zakat
- **zakat**: Transaksi zakat masuk
- **donasi**: Transaksi donasi
- **permohonan**: Pengajuan bantuan mustahik
- **penyaluran**: Distribusi dana keluar
- **program**: Program bantuan
- **kategori**: Kategori program

### 8 Kategori Asnaf
fakir, miskin, amil, muallaf, riqab, ghamrin, fisabillah, ibnusabil

## 🔐 Role & Permission

- **Admin**: Full access semua modul
- **Program**: Kelola program dan permohonan
- **Keuangan**: Kelola transaksi keuangan
- **Ketua**: Monitor dan analisis
- **Donatur**: Submit zakat dan donasi
- **Mustahik**: Ajukan permohonan bantuan

## 🧪 Testing

```bash
# Run all tests
composer test

# Specific test
vendor/bin/phpunit tests/unit/HealthTest.php
```

## 📄 License

MIT License - lihat file `LICENSE` untuk detail.

## Pengembang

**PRAMUDITO METRA**

## 📞 Kontak

- **Website**: https://portfolio-pramudito.vercel.app/
- **Email**: pramuditometra@gmail.com
Copyright (c) 2025 Pramudito Metra
