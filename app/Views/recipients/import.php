<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <?php if (session()->getFlashdata('message')): ?>
        <div id="alert-success" class="flex items-center p-4 mb-6 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <div class="ms-3 text-sm font-bold">
                <?= session()->getFlashdata('message') ?>
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-100 inline-flex items-center justify-center h-8 w-8 transition-colors" data-dismiss-target="#alert-success" aria-label="Close">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div id="alert-error" class="flex items-center p-4 mb-6 text-red-800 rounded-2xl bg-red-50 border border-red-100 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation text-lg"></i>
            <div class="ms-3 text-sm font-bold">
                <?= session()->getFlashdata('error') ?>
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-100 inline-flex items-center justify-center h-8 w-8 transition-colors" data-dismiss-target="#alert-error" aria-label="Close">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    <?php endif; ?>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-900">Panduan Impor Excel</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-sm font-semibold text-gray-900 uppercase mb-3">1. Format File</h3>
                <p class="text-sm text-gray-600 mb-4">Pastikan file Excel Anda memiliki kolom berikut:</p>
                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4 font-mono text-xs text-emerald-800 shadow-sm">
                    <table class="w-full">
                        <tr class="text-emerald-600 border-b border-emerald-200">
                            <th class="text-left pb-2 font-bold">Kolom A</th>
                            <th class="text-left pb-2 font-bold">Kolom B</th>
                            <th class="text-left pb-2 font-bold">Kolom C</th>
                        </tr>
                        <tr>
                            <td class="py-2 font-bold">nama</td>
                            <td class="py-2 font-bold">jabatan (opsional)</td>
                            <td class="py-2 font-bold">alamat (opsional)</td>
                        </tr>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="/template_impor_labelpro.xlsx" class="text-sm font-semibold text-emerald-600 hover:underline" download>
                        <i class="fa-solid fa-download me-2"></i>
                        Unduh Template Excel
                    </a>
                </div>
            </div>
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase mb-3">2. Ketentuan</h3>
                <ul class="text-sm text-gray-600 space-y-2 list-disc list-inside">
                    <li>Baris pertama (header) akan otomatis dilewati.</li>
                    <li>Nama tidak boleh kosong.</li>
                    <li>Data dengan <strong>nama, jabatan, dan alamat yang sama</strong> akan otomatis dilewati.</li>
                    <li>Format file harus <strong>.xlsx</strong>.</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center">
        <form action="/recipients/import" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="event_id" value="<?= esc($event['id']) ?>">
            
            <div class="mb-6 text-left max-w-sm mx-auto">
                <label class="block mb-2 text-sm font-bold text-gray-900">Impor ke Acara</label>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-lg block w-full p-3 shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fa-solid fa-folder me-2 text-emerald-600"></i>
                        <?= esc($event['name']) ?>
                    </div>
                    <a href="/events" class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest hover:underline px-2 py-1 bg-white rounded-md border border-emerald-200 shadow-sm transition-all hover:bg-emerald-100">Ubah</a>
                </div>
                <p class="mt-2 text-[10px] text-gray-500 italic">Semua data dari file Excel akan otomatis ditambahkan ke acara ini.</p>
            </div>
            <div class="mb-6">
                <label for="excel_file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-emerald-600 mb-3"></i>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-bold">Klik untuk pilih file</span> atau drag and drop</p>
                        <p class="text-xs text-gray-400" id="file-name">XLSX (Maks. 10MB)</p>
                    </div>
                    <input id="excel_file" name="excel_file" type="file" class="hidden" accept=".xlsx" required />
                </label>
            </div>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-all">
                Mulai Impor Data
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('excel_file').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : "XLSX (Maks. 10MB)";
        document.getElementById('file-name').textContent = fileName;
        document.getElementById('file-name').classList.add('text-emerald-600', 'font-bold');
    });
</script>
<?= $this->endSection() ?>
