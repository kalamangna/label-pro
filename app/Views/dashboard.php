<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
    <!-- Total Events Card -->
    <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-emerald-200 transition-all group">
        <div class="flex items-center mb-4">
            <div class="p-3 mr-4 text-emerald-600 bg-emerald-50 rounded-xl">
                <i class="fa-solid fa-folder-open text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Acara</p>
                <p class="text-3xl font-extrabold tracking-tight text-gray-900"><?= number_format($totalEvents) ?></p>
            </div>
        </div>

        <?php if (session()->get('role') === 'admin'): ?>
            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mb-4 italic">Ringkasan Sistem</p>
        <?php elseif ($package !== 'unlimited'): ?>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mb-1">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: <?= min(100, ($totalEvents / $limits['max_events']) * 100) ?>%"></div>
            </div>
            <p class="text-[10px] text-gray-500 font-medium mb-4">Quota: <?= number_format($totalEvents) ?> / <?= number_format($limits['max_events']) ?> (<?= $limits['name'] ?>)</p>
        <?php else: ?>
            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mb-4 italic">Akses Tanpa Batas</p>
        <?php endif; ?>

        <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
            <a href="/events" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                Kelola Acara
                <i class="fa-solid fa-chevron-right ms-2 text-xs transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>

    <!-- Total Guests Card -->
    <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-amber-200 transition-all group">
        <div class="flex items-center mb-4">
            <div class="p-3 mr-4 text-amber-600 bg-amber-50 rounded-xl">
                <i class="fa-solid fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Tamu</p>
                <p class="text-3xl font-extrabold tracking-tight text-gray-900"><?= number_format($totalGuests) ?></p>
            </div>
        </div>

        <?php if (session()->get('role') === 'admin'): ?>
            <p class="text-[10px] text-amber-600 font-bold uppercase tracking-widest mb-4 italic">Ringkasan Sistem</p>
        <?php elseif ($package !== 'unlimited'): ?>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mb-1">
                <div class="bg-amber-500 h-1.5 rounded-full" style="width: <?= min(100, ($totalGuests / $limits['max_guests']) * 100) ?>%"></div>
            </div>
            <p class="text-[10px] text-gray-500 font-medium mb-4">Quota: <?= number_format($totalGuests) ?> / <?= number_format($limits['max_guests']) ?> (<?= $limits['name'] ?>)</p>
        <?php else: ?>
            <p class="text-[10px] text-amber-600 font-bold uppercase tracking-widest mb-4 italic">Akses Tanpa Batas</p>
        <?php endif; ?>

        <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
            <a href="/guests" class="text-sm font-bold text-amber-600 hover:text-amber-700 inline-flex items-center">
                Kelola Tamu
                <i class="fa-solid fa-chevron-right ms-2 text-xs transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>

    <?php if (session()->get('role') === 'admin'): ?>
        <!-- Manage Users Card -->
        <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-purple-200 transition-all group">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-purple-600 bg-purple-50 rounded-xl">
                    <i class="fa-solid fa-user-gear text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pengguna</p>
                    <p class="text-3xl font-extrabold tracking-tight text-gray-900"><?= number_format($totalUsers) ?></p>
                </div>
            </div>

            <p class="text-[10px] text-purple-600 font-bold uppercase tracking-widest mb-4 italic">Kontrol Akun</p>

            <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                <a href="/users" class="text-sm font-bold text-purple-600 hover:text-purple-700 inline-flex items-center">
                    Kelola Pengguna
                    <i class="fa-solid fa-chevron-right ms-2 text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Quick Import -->
        <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-emerald-200 transition-all group">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-emerald-600 bg-emerald-50 rounded-xl">
                    <i class="fa-solid fa-file-excel text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Format Data</p>
                    <p class="text-2xl font-extrabold tracking-tight text-gray-900">XLSX</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-50">
                <a href="/events" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                    Pilih Acara & Impor
                    <i class="fa-solid fa-upload ms-2 text-xs transition-transform group-hover:-translate-y-1"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Simple Welcome Section -->
<div class="p-10 bg-gray-50/50 border border-dashed border-gray-200 rounded-2xl text-center md:text-left">
    <div class="max-w-xl">
        <?php if (session()->get('role') === 'admin'): ?>
            <p class="text-lg text-gray-600 leading-relaxed mb-8 font-medium">
                Selamat datang di Panel Administrator. Anda dapat mengelola akun pengguna dan memantau keseluruhan data sistem.
            </p>
            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                <a href="/users" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-bold rounded-xl text-sm px-8 py-3 transition-all active:scale-95 shadow-lg shadow-purple-100">
                    <i class="fa-solid fa-user-gear me-2"></i>
                    Kelola Pengguna
                </a>
                <a href="/panduan" class="text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-bold rounded-xl text-sm px-8 py-3 transition-all active:scale-95 shadow-sm">
                    <i class="fa-solid fa-book-open me-2 text-amber-500"></i>
                    Baca Panduan
                </a>
            </div>
        <?php else: ?>
            <p class="text-lg text-gray-600 leading-relaxed mb-8 font-medium">
                Kelola tamu undangan dan cetak label stiker secara instan. Gunakan menu di samping untuk mulai atau klik tombol di bawah.
            </p>
            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                <a href="/events" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 font-bold rounded-xl text-sm px-8 py-3 transition-all active:scale-95 shadow-lg shadow-emerald-100">
                    <i class="fa-solid fa-folder-open me-2"></i>
                    Pilih Acara
                </a>
                <a href="/panduan" class="text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-bold rounded-xl text-sm px-8 py-3 transition-all active:scale-95 shadow-sm">
                    <i class="fa-solid fa-book-open me-2 text-amber-500"></i>
                    Baca Panduan
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>