# LabelPro

LabelPro adalah aplikasi berbasis web modern untuk manajemen daftar tamu dan pencetakan label undangan otomatis (tipe 121) dengan presisi tinggi.

## Fitur Utama
- **Sistem Pengguna**: Mendukung Multi-User RBAC (Admin, User) serta Mode Demo instan.
- **Manajemen Acara**: Kelola daftar tamu berdasarkan Acara (Event) untuk pengelompokan yang lebih rapi.
- **Manajemen Data**: Tambah, ubah, dan impor data penerima dengan mudah. Mendukung persistensi seleksi antar halaman (server-side).
- **Impor Excel**: Impor ribuan data tamu secara massal menggunakan file Excel (.xlsx).
- **Sticky Selection Toolbar**: Pantau jumlah penerima terpilih dan cetak label secara instan dari halaman mana pun.
- **Filter Canggih**: Cari dan filter data berdasarkan Nama, Alamat, Status Cetak, atau Acara dengan ringkasan hasil yang informatif.
- **Panduan Visual**: Ilustrasi interaktif untuk posisi cetak dan perataan kertas dengan fitur preview gambar untuk akurasi maksimal.
- **Label Offset**: Fitur cerdas untuk memulai cetak dari posisi mana pun pada kertas stiker, menghemat penggunaan kertas yang sudah terpakai sebagian.
- **Pencetakan Akurat**: Layout presisi untuk label stiker tipe 121 (38x75mm) pada kertas A4 dengan visualisasi pratinjau yang realistis.

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
LabelPro dikembangkan oleh **kalamangna**. Ditujukan untuk mempermudah pekerjaan Wedding Organizer, staf kantor, dan bisnis percetakan.
