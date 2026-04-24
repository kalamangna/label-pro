# LabelPro

LabelPro adalah aplikasi berbasis web modern untuk manajemen daftar tamu dan pencetakan label undangan otomatis (tipe 121) dengan presisi tinggi.

## Fitur Utama
- **Sistem Pengguna**: Mendukung Multi-User RBAC (Admin, User) serta Mode Demo instan.
- **Manajemen Acara**: Kelola daftar tamu berdasarkan Acara (Event) untuk pengelompokan yang lebih rapi. Pengguna dapat masuk ke konteks acara tertentu untuk manajemen tamu yang lebih fokus.
- **Manajemen Tamu**: Tambah, ubah, dan impor tamu dengan mudah. Mendukung kolom **Jabatan (Opsional)** dan persistensi seleksi antar halaman (server-side).
- **Impor Excel**: Impor ribuan tamu secara massal menggunakan file Excel (.xlsx) dengan struktur Nama, Jabatan, dan Alamat ke dalam acara pilihan.
- **Sticky Selection Toolbar**: Pantau jumlah tamu terpilih, lakukan aksi massal (Hapus/Tanda Cetak), dan cetak label secara instan dari halaman mana pun.
- **Multi-page Printing**: Otomatis membagi tamu terpilih ke dalam beberapa halaman/lembar stiker (10 label per halaman).
- **Filter & Urutan**: Cari dan filter tamu berdasarkan Nama, Jabatan, Alamat, atau Status Cetak dengan UI filter yang konsisten dan informatif. Konteks filter dipertahankan saat melakukan pengubahan data.
- **Smart Duplicate Check**: Deteksi otomatis data tamu yang identik atau mirip menggunakan algoritma fuzzy matching tingkat lanjut yang dioptimalkan. Sistem memvalidasi kesamaan Nama (60%), Jabatan (15%), dan Alamat (25%) dengan normalisasi otomatis terhadap gelar (Ir., Dr., dll) dan variasi penulisan nama (contoh: Muhammad vs Muh.). Termasuk fitur **"Bukan Duplikat"** untuk menandai data unik agar tidak muncul kembali di pengecekan selanjutnya.
- **Panduan Penggunaan**: Halaman panduan terintegrasi yang menjelaskan alur kerja aplikasi, tips mencetak, dan spesifikasi label.
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
- Gunakan fitur **Panduan Penggunaan** di dalam aplikasi untuk tips operasional lebih lanjut.

## Lisensi
LabelPro dikembangkan oleh **kalamangna**. Ditujukan untuk mempermudah pekerjaan Wedding Organizer, staf kantor, dan bisnis percetakan.
