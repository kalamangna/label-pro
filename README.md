# LabelPro

LabelPro adalah aplikasi berbasis web untuk manajemen daftar tamu dan pencetakan label undangan otomatis (tipe 103 & 121) dengan presisi tinggi.

## Fitur Utama
- **Dashboard Modern**: Tampilan profesional dengan sidebar responsif.
- **Manajemen Penerima**: CRUD (Tambah, Ubah, Hapus) data penerima dengan mudah.
- **Impor Excel**: Masukkan ribuan data tamu sekaligus via file .xlsx.
- **Alur Kerja Cetak**: Tandai tamu yang ingin dicetak dan pantau status yang sudah diprint.
- **Presisi Tinggi**: Template label tipe 103 dan 121 yang akurat untuk kertas A4.
- **Export PDF**: Unduh hasil label dalam format PDF berkualitas tinggi.
- **Cegah Duplikat**: Sistem otomatis mendeteksi nama ganda saat input maupun impor.

## Persyaratan Sistem
- PHP 8.2 atau lebih tinggi.
- MySQL / MariaDB.
- Composer.
- Node.js & NPM (untuk aset Tailwind/Vite).

## Instalasi
1. Clone repositori ini.
2. Jalankan `composer install`.
3. Jalankan `npm install`.
4. Salin `env` ke `.env` dan sesuaikan pengaturan database.
5. Jalankan migrasi: `php spark migrate`.
6. Jalankan server pembangunan:
   - PHP: `php spark serve`
   - Assets: `npm run dev`

## Lisensi
Aplikasi ini dikembangkan untuk mempermudah pekerjaan Wedding Organizer, staf kantor, dan bisnis percetakan.
