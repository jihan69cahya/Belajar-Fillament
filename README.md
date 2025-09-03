<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
    </a>
</p>

<h2 align="center">📌 Laravel + Filament Learning Project</h2>

<p align="center">
    Repository ini dibuat untuk belajar membangun aplikasi menggunakan <b>Laravel</b> dan <b>Filament Admin Panel</b>.
</p>

---

## 🚀 Tentang Project

Project ini merupakan eksperimen dan sarana belajar saya untuk memahami:

- Dasar-dasar **Laravel Framework**.
- Penggunaan **Filament** untuk membangun panel admin modern.
- Manajemen data dengan **Eloquent ORM**.
- Penerapan **TailwindCSS** melalui Filament.
- Best practice struktur project Laravel.

---

## 🛠️ Tech Stack

- [Laravel](https://laravel.com) - PHP Framework
- [Filament](https://filamentphp.com) - Admin Panel & Form/Table builder
- [Tailwind CSS](https://tailwindcss.com) - Styling
- [MySQL / PostgreSQL] - Database (sesuaikan dengan config lokal)

---

## ⚙️ Instalasi

Ikuti langkah berikut untuk menjalankan project di lokal:

```bash
# Clone repository
git clone https://github.com/username/nama-repo.git

cd nama-repo

# Install dependency PHP
composer install

# Copy file .env
cp .env.example .env

# Generate key
php artisan key:generate

# Sesuaikan database di .env lalu jalankan migration
php artisan migrate

# Install dependency frontend (opsional, jika perlu)
npm install && npm run dev

# Jalankan server
php artisan serve
