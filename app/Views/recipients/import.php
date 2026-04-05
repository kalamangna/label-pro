<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-200">
        <div class="px-4 py-5 sm:p-6 bg-emerald-50 border-b border-emerald-100">
            <h3 class="text-lg font-bold text-emerald-900">Panduan Impor Excel</h3>
            <p class="mt-1 text-sm text-emerald-700">Ikuti langkah-langkah berikut agar proses impor berjalan lancar.</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-2 uppercase tracking-wider">Format Yang Dibutuhkan</h4>
                    <p class="text-sm text-gray-500 mb-4">File Excel Anda harus memiliki dua kolom di sheet pertama:</p>
                    <div class="bg-gray-800 rounded-lg p-3 text-xs font-mono text-gray-300">
                        <table class="w-full">
                            <tr class="text-gray-500 border-b border-gray-700">
                                <th class="text-left pb-1">A</th>
                                <th class="text-left pb-1">B</th>
                            </tr>
                            <tr>
                                <td class="py-1 text-emerald-400">nama</td>
                                <td class="py-1 text-emerald-400">alamat</td>
                            </tr>
                            <tr>
                                <td class="py-1">Budi Santoso</td>
                                <td class="py-1">Jl. Melati No. 12, Jakarta</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Baris pertama</strong> akan selalu dilewati karena dianggap sebagai judul kolom (header). Pastikan nama dan alamat tidak kosong.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="rounded-md bg-red-50 p-4 mt-6 border border-red-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="mt-8 bg-white shadow sm:rounded-lg border border-gray-200">
        <div class="px-4 py-5 sm:p-6">
            <form action="/recipients/import" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 gap-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition-colors cursor-pointer group" onclick="document.getElementById('excel_file').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-emerald-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <span class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500">
                                        Unggah file
                                    </span>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500" id="file-name">Khusus file XLSX maksimal 10MB</p>
                                <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx" required>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Mulai Proses Impor
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('excel_file').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : "Khusus file XLSX maksimal 10MB";
        document.getElementById('file-name').textContent = fileName;
        document.getElementById('file-name').classList.add('text-emerald-600', 'font-bold');
    });
</script>
<?= $this->endSection() ?>
