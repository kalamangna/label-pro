# LabelPro

LabelPro adalah aplikasi berbasis web modern untuk manajemen daftar tamu dan pencetakan label undangan otomatis (tipe 121) dengan presisi tinggi.

## Fitur Utama
- **Sistem Pengguna**: Mendukung Multi-User RBAC (Admin, User) serta Mode Demo instan.
- **Manajemen Data**: Tambah, ubah, dan impor data penerima dengan mudah dalam satu halaman. Termasuk fitur Aksi Massal (hapus dan status cetak).
- **Impor Excel & Template**: Impor ribuan data tamu secara massal menggunakan file Excel (.xlsx).
- **Pencarian & Penyaringan**: Temukan dan urutkan data secara instan.
- **Pencetakan Akurat**: Layout presisi untuk label stiker tipe 121 pada kertas A4, didukung fitur PDF Export (Dompdf).

## Persyaratan Sistem
- PHP 8.2 atau lebih tinggi.
- Database (MySQL, MariaDB, atau SQLite).
- Composer & Node.js/NPM (untuk build Tailwind/Vite).

## Instalasi
1. Clone repositori ini.
2. Jalankan `composer install` dan `npm install`.
3. Salin `env` ke `.env` dan sesuaikan pengaturan database.
4. Jalankan migrasi dan seeder:
   ```bash
   php spark migrate
   php spark db:seed UserSeeder
   ```
5. Jalankan server pembangunan:
   - PHP: `php spark serve`
   - Assets: `npm run dev`

## Penggunaan
- Pastikan pengaturan margin browser disetel ke "None" dan Scale ke "100%" saat mencetak langsung.

## Lisensi
LabelPro dikembangkan oleh **kalamangna**. Dikembangkan untuk mempermudah pekerjaan Wedding Organizer, staf kantor, dan bisnis percetakan.
