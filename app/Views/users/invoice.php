<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                background-color: white;
            }
            .invoice-card {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    <div class="max-w-3xl mx-auto py-12 px-6">
        <!-- Actions -->
        <div class="no-print flex justify-between items-center mb-8">
            <a href="/users" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Kembali ke Daftar
            </a>
            <button onclick="window.print()" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                <i class="fa-solid fa-print me-2"></i>
                Cetak Invoice
            </button>
        </div>

        <!-- Invoice Card -->
        <div class="invoice-card bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-emerald-600 p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-file-invoice text-9xl"></i>
                </div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight mb-2">LABELPRO</h1>
                        <p class="text-emerald-50 text-xs font-medium uppercase tracking-widest">Sistem Cetak Label Tamu</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-bold mb-1">INVOICE</h2>
                        <p class="text-emerald-100 text-sm"><?= esc($invoice_no) ?></p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-8 mb-12">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Diterbitkan Oleh</p>
                        <p class="font-bold text-gray-900">LabelPro Admin</p>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Jakarta, Indonesia<br>
                            admin@labelpro.id
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Ditagihkan Kepada</p>
                        <p class="font-bold text-gray-900"><?= esc($user['username']) ?></p>
                        <p class="text-sm text-gray-500 uppercase">Peran: <?= esc($user['role']) ?></p>
                        <p class="text-sm text-gray-500 mt-2">
                            Tanggal: <?= date('d F Y', strtotime($user['created_at'])) ?>
                        </p>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-hidden border border-gray-100 rounded-2xl mb-8">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Deskripsi Layanan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr>
                                <td class="px-6 py-6">
                                    <p class="font-bold text-gray-900 mb-1">Aktivasi <?= esc($package_name) ?></p>
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Lisensi penggunaan sistem LabelPro untuk paket <?= strtolower($package_name) ?>.
                                        Sesuai dengan ketentuan yang berlaku pada akun pengguna.
                                    </p>
                                </td>
                                <td class="px-6 py-6 text-right font-bold text-gray-900">
                                    Rp <?= number_format($price, 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                            <tr>
                                <td class="px-6 py-4 text-sm font-bold text-gray-500 text-right">Total Tagihan</td>
                                <td class="px-6 py-4 text-xl font-black text-emerald-600 text-right">
                                    Rp <?= number_format($price, 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Footer Note -->
                <?php if (($user['payment_status'] ?? 'belum') === 'lunas'): ?>
                <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-6 text-center">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 mb-3">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h3 class="font-bold text-emerald-900 mb-1">Invoice Lunas</h3>
                    <p class="text-xs text-emerald-700">Pembayaran telah dikonfirmasi dan layanan telah aktif.</p>
                </div>
                <?php else: ?>
                <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-6 text-center">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-100 text-amber-600 mb-3">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3 class="font-bold text-amber-900 mb-1">Menunggu Pembayaran</h3>
                    <p class="text-xs text-amber-700">Silakan lakukan pembayaran untuk mengaktifkan layanan.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Bottom Stripe -->
            <div class="p-8 border-t border-gray-50 text-center">
                <p class="text-[10px] text-gray-400 font-medium leading-relaxed">
                    Terima kasih telah menggunakan layanan LabelPro.<br>
                    Invoice ini dihasilkan secara otomatis oleh sistem dan merupakan bukti pembayaran yang sah.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
