<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
    <!-- Total Recipients Card -->
    <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-emerald-200 transition-all group">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-emerald-600 bg-emerald-50 rounded-xl">
                <i class="fa-solid fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Penerima</p>
                <p class="text-3xl font-extrabold tracking-tight text-gray-900"><?= number_format($totalRecipients) ?></p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
            <a href="/recipients" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                Kelola Data
                <i class="fa-solid fa-chevron-right ms-2 text-xs transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>

    <!-- Label Templates -->
    <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-amber-600 bg-amber-50 rounded-xl">
                <i class="fa-solid fa-tags text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Template</p>
                <p class="text-2xl font-extrabold tracking-tight text-gray-900">103 & 121</p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-50">
            <span class="text-xs font-medium text-gray-400 italic">Kertas A4 Standard</span>
        </div>
    </div>

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
            <a href="/recipients/import" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                Mulai Impor
                <i class="fa-solid fa-upload ms-2 text-xs transition-transform group-hover:-translate-y-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Simple Welcome Section -->
<div class="p-10 bg-gray-50/50 border border-dashed border-gray-200 rounded-2xl text-center md:text-left">
    <div class="max-w-xl">
        <p class="text-lg text-gray-600 leading-relaxed mb-8 font-medium">
            Kelola tamu undangan dan cetak label stiker secara instan. Gunakan menu di samping untuk mulai atau klik tombol di bawah.
        </p>
        <div class="flex flex-wrap gap-4 justify-center md:justify-start">
            <a href="/recipients/import" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 font-bold rounded-xl text-sm px-8 py-3 transition-all active:scale-95 shadow-lg shadow-emerald-100">
                <i class="fa-solid fa-file-import me-2"></i>
                Impor Excel
            </a>
            <a href="/recipients" class="text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-bold rounded-xl text-sm px-8 py-3 transition-all active:scale-95 shadow-sm">
                <i class="fa-solid fa-table-list me-2"></i>
                Lihat Semua
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
