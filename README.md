# LabelPro

LabelPro adalah aplikasi berbasis web modern untuk manajemen daftar tamu dan pencetakan label undangan otomatis (tipe 103 & 121) dengan presisi tinggi.

## Fitur Utama
- **Multi-User RBAC**: Dukungan peran Admin, User, dan Demo dengan isolasi data yang aman.
- **Single Page CRUD**: Kelola penerima dan pengguna secara instan melalui sistem Modal tanpa pindah halaman.
- **Mode Demo**: Akses demo langsung tanpa registrasi dengan lingkungan data terisolasi.
- **Aksi Massal**: Hapus banyak data sekaligus atau tandai status cetak secara kolektif.
- **Impor Excel & Template**: Masukkan ribuan data tamu via file .xlsx dan unduh template format yang sudah disediakan.
- **Filter & Sorting Cerdas**: Cari dan urutkan data berdasarkan nama atau alamat (A-Z/Z-A) serta filter status cetak.
- **Presisi Label**: Dukungan akurat untuk label tipe 103 dan 121 pada kertas A4 dengan fitur "di-" prefix otomatis.
- **Waktu Indonesia (WIB)**: Seluruh sistem menggunakan zona waktu Asia/Jakarta untuk akurasi data.
- **Export PDF**: Unduh hasil label dalam format PDF berkualitas tinggi menggunakan Dompdf.

## Persyaratan Sistem
- PHP 8.2 atau lebih tinggi.
- MySQL / MariaDB / SQLite.
- Composer.
- Node.js & NPM (untuk aset Tailwind/Vite).

## Instalasi
1. Clone repositori ini.
2. Jalankan `composer install`.
3. Jalankan `npm install`.
4. Salin `env` ke `.env` dan sesuaikan pengaturan database.
5. Jalankan migrasi dan seeder:
   ```bash
   php spark migrate
   php spark db:seed UserSeeder
   ```
6. Jalankan server pembangunan:
   - PHP: `php spark serve`
   - Assets: `npm run dev`

## Penggunaan
- Pastikan pengaturan margin browser disetel ke "None" dan Scale ke "100%" saat mencetak langsung.

## Lisensi
LabelPro dikembangkan oleh **kalamangna**. Dikembangkan untuk mempermudah pekerjaan Wedding Organizer, staf kantor, dan bisnis percetakan.
