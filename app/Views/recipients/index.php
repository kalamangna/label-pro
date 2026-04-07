<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-6">
    <div class="flex items-center gap-4">
        <div class="bg-emerald-600 p-3 rounded-2xl shadow-lg shadow-emerald-100">
            <i class="fa-solid fa-users text-white text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 leading-none mb-1">Daftar Penerima</h1>
            <p class="text-sm text-gray-500 font-medium">
                Total <span class="text-emerald-600 font-bold"><?= number_format($pager->getTotal()) ?></span> penerima dalam database Anda
            </p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="/recipients/import" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-3 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                <i class="fa-solid fa-file-import me-2 text-emerald-600"></i>
                Impor
            </a>

            <button data-modal-target="add-recipient-modal" data-modal-toggle="add-recipient-modal" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                <i class="fa-solid fa-plus me-2"></i>
                Tambah
            </button>
        </div>

        <div class="h-10 w-px bg-gray-200 hidden sm:block mx-2"></div>

        <button id="printLabelBtn" class="flex-1 sm:flex-none text-white bg-amber-500 border border-amber-600 hover:bg-amber-600 focus:ring-4 focus:ring-amber-100 font-bold rounded-xl text-sm px-8 py-3 inline-flex items-center justify-center transition-all shadow-xl shadow-amber-100 active:scale-95" type="button">
            <i class="fa-solid fa-print me-2 text-lg"></i>
            Cetak Label
        </button>
    </div>
</div>

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

<!-- Filters -->
<div class="mb-4 p-6 bg-gray-50/50 border border-gray-200 rounded-2xl">
    <form action="/recipients" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <!-- Search -->
        <div class="md:col-span-4 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
            </div>
            <input type="text" name="search" value="<?= esc($search ?? '') ?>" class="block w-full ps-9 text-sm text-gray-900 border border-slate-300 rounded-xl bg-white focus:ring-slate-500 focus:border-slate-500 h-[42px] transition-all placeholder-slate-400" placeholder="Cari nama atau alamat...">
        </div>

        <!-- Status Filter -->
        <div class="md:col-span-3">
            <select name="status" class="bg-white border border-slate-300 text-gray-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block w-full h-[42px] px-2.5 transition-all">
                <option value="">Semua Status</option>
                <option value="0" <?= (string)($status ?? '') === '0' ? 'selected' : '' ?>>Belum Dicetak</option>
                <option value="1" <?= (string)($status ?? '') === '1' ? 'selected' : '' ?>>Sudah Dicetak</option>
            </select>
        </div>

        <!-- Sort Filter -->
        <div class="md:col-span-3">
            <select name="sort_select" id="sort-select" class="bg-white border border-slate-300 text-gray-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block w-full h-[42px] px-2.5 transition-all">
                <option value="id|desc" <?= ($sort ?? '') == 'id' ? 'selected' : '' ?>>Urutan: Terbaru</option>
                <option value="name|asc" <?= ($sort ?? '') == 'name' && ($dir ?? 'asc') == 'asc' ? 'selected' : '' ?>>Nama: A-Z</option>
                <option value="name|desc" <?= ($sort ?? '') == 'name' && ($dir ?? 'asc') == 'desc' ? 'selected' : '' ?>>Nama: Z-A</option>
                <option value="address|asc" <?= ($sort ?? '') == 'address' && ($dir ?? 'asc') == 'asc' ? 'selected' : '' ?>>Alamat: A-Z</option>
                <option value="address|desc" <?= ($sort ?? '') == 'address' && ($dir ?? 'asc') == 'desc' ? 'selected' : '' ?>>Alamat: Z-A</option>
            </select>
            <input type="hidden" name="sort" id="real-sort" value="<?= esc($sort ?? 'id') ?>">
            <input type="hidden" name="dir" id="real-dir" value="<?= esc($dir ?? 'desc') ?>">
        </div>

        <!-- Buttons -->
        <div class="md:col-span-2 flex gap-2">
            <button type="submit" class="flex-1 h-[42px] bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 focus:ring-4 focus:ring-slate-200 transition-all active:scale-95 shadow-md shadow-slate-200 flex items-center justify-center">Filter</button>
            <?php if (!empty($search) || ($status ?? '') !== '' || ($sort ?? 'id') !== 'id'): ?>
                <a href="/recipients" class="flex-1 h-[42px] flex items-center justify-center bg-white border border-slate-300 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all active:scale-95 text-center">Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Bulk Actions Bar -->
<div class="mb-6 flex flex-wrap items-center gap-2 p-2 bg-emerald-50/50 border border-emerald-100 rounded-xl">
    <span class="text-[10px] uppercase tracking-widest font-black text-emerald-800 px-3 py-1">Aksi Massal:</span>
    <button id="bulkDeleteBtn" type="button" class="text-red-600 bg-white border border-gray-200 hover:bg-red-50 focus:ring-4 focus:ring-red-100 font-bold rounded-lg text-[10px] px-3 py-1.5 inline-flex items-center transition-all">
        <i class="fa-solid fa-trash-can me-1.5"></i>
        Hapus
    </button>
    <button id="bulkMarkPrintedBtn" type="button" class="text-emerald-700 bg-white border border-gray-200 hover:bg-emerald-50 focus:ring-4 focus:ring-emerald-100 font-bold rounded-lg text-[10px] px-3 py-1.5 inline-flex items-center transition-all">
        <i class="fa-solid fa-check-double me-1.5"></i>
        Tandai Sudah Cetak
    </button>
    <button id="bulkMarkNotPrintedBtn" type="button" class="text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-bold rounded-lg text-[10px] px-3 py-1.5 inline-flex items-center transition-all">
        <i class="fa-solid fa-rotate-left me-1.5"></i>
        Tandai Belum Cetak
    </button>
</div>

<!-- Table -->
<div class="relative overflow-x-auto border border-gray-100 sm:rounded-2xl shadow-sm bg-white">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">
            <tr>
                <th scope="col" class="p-4 w-4 text-center">
                    <input id="select-all" type="checkbox" class="w-4 h-4 text-emerald-600 bg-white border-gray-200 rounded focus:ring-emerald-500 cursor-pointer">
                </th>
                <th scope="col" class="px-6 py-4 font-bold">Nama Penerima</th>
                <th scope="col" class="px-6 py-4 font-bold">Alamat</th>
                <?php if (session()->get('role') === 'admin'): ?>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Ditambahkan Oleh</th>
                <?php endif; ?>
                <th scope="col" class="px-6 py-4 text-center font-bold">Status</th>
                <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($recipients as $recipient): ?>
                <tr id="row-<?= $recipient['id'] ?>" class="bg-white hover:bg-emerald-50/30 transition-colors <?= ($recipient['is_printed'] ?? 0) ? 'bg-gray-50/30' : '' ?>">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="w-4 h-4 text-emerald-600 bg-white border-gray-200 rounded focus:ring-emerald-500 cursor-pointer toggle-select" data-id="<?= $recipient['id'] ?>">
                    </td>
                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap <?= ($recipient['is_printed'] ?? 0) ? 'line-through text-gray-400 font-medium' : '' ?>">
                        <?= esc($recipient['name']) ?>
                    </th>
                    <td class="px-6 py-4 <?= ($recipient['is_printed'] ?? 0) ? 'line-through text-gray-400 font-medium' : 'text-gray-600 font-medium' ?>">
                        <div class="line-clamp-1"><?= esc($recipient['address']) ?></div>
                    </td>
                    <?php if (session()->get('role') === 'admin'): ?>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-gray-200">
                                <?= esc($recipient['added_by'] ?? 'Tidak diketahui') ?>
                            </span>
                        </td>
                    <?php endif; ?>
                    <td class="px-6 py-4 text-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer toggle-printed" data-id="<?= $recipient['id'] ?>" <?= ($recipient['is_printed'] ?? 0) ? 'checked' : '' ?>>
                            <div class="relative w-8 h-4 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button type="button" class="p-2 text-gray-400 hover:text-emerald-600 transition-colors edit-recipient-btn" 
                                    data-id="<?= $recipient['id'] ?>" 
                                    data-name="<?= esc($recipient['name']) ?>" 
                                    data-address="<?= esc($recipient['address']) ?>"
                                    title="Edit">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <button type="button" data-modal-target="delete-modal-<?= $recipient['id'] ?>" data-modal-toggle="delete-modal-<?= $recipient['id'] ?>" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>

                        <!-- Delete Modal -->
                        <div id="delete-modal-<?= $recipient['id'] ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 text-left">
                                    <div class="p-6 text-center">
                                        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-circle-exclamation text-xl"></i>
                                        </div>
                                        <h3 class="mb-2 text-lg font-bold text-gray-900">Hapus data ini?</h3>
                                        <p class="mb-6 text-sm text-gray-500 italic">"<?= esc($recipient['name']) ?>"</p>
                                        <div class="flex justify-center gap-3">
                                            <button data-modal-hide="delete-modal-<?= $recipient['id'] ?>" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                                            <a href="/recipients/delete/<?= $recipient['id'] ?>" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-100">Hapus Data</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($recipients)): ?>
                <tr>
                    <td colspan="<?= session()->get('role') === 'admin' ? '6' : '5' ?>" class="px-6 py-16 text-center bg-gray-50/30 text-gray-400 font-medium">
                        <div class="max-w-xs mx-auto text-center">
                            <i class="fa-solid fa-inbox text-4xl mb-4 opacity-20 text-emerald-600"></i>
                            <p class="text-sm font-bold text-gray-900 mb-1">Belum ada data</p>
                            <p class="text-xs text-gray-500 leading-relaxed">Gunakan tombol Tambah atau Impor untuk mengisi daftar penerima label Anda.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-8 flex justify-center">
    <?= $pager->links('default', 'tailwind') ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const headers = {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        };

        const selectAllCheckbox = document.getElementById('select-all');
        const selectCheckboxes = document.querySelectorAll('.toggle-select');

        function updateSelectAllState() {
            const checkedCount = document.querySelectorAll('.toggle-select:checked').length;
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = checkedCount === selectCheckboxes.length && checkedCount > 0;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < selectCheckboxes.length;
            }
        }

        selectCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.toggle-select:checked').length;

                if (this.checked && checkedCount > 10) {
                    alert('Maksimal 10 penerima yang dapat dipilih.');
                    this.checked = false;
                    return;
                }
                updateSelectAllState();
            });
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                
                let count = 0;
                selectCheckboxes.forEach((cb) => {
                    if (isChecked && count < 10) {
                        cb.checked = true;
                        count++;
                    } else {
                        cb.checked = false;
                    }
                });

                if (isChecked && selectCheckboxes.length > 10) {
                    alert('Hanya 10 data pertama yang dipilih karena batas maksimal cetak.');
                }
                updateSelectAllState();
            });
        }

        updateSelectAllState();

        document.querySelectorAll('.toggle-printed').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                const originalState = !this.checked;
                const row = document.getElementById(`row-${id}`);
                const nameEl = row.querySelector('th');
                const addrEl = row.querySelector('td div');

                fetch(`/recipients/printed/${id}`, {
                    method: 'POST',
                    headers: headers,
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        if (data.is_printed == 1) {
                            row.classList.add('bg-gray-50/30');
                            nameEl.classList.add('line-through', 'text-gray-400');
                            addrEl.classList.add('line-through', 'text-gray-400');
                        } else {
                            row.classList.remove('bg-gray-50/30');
                            nameEl.classList.remove('line-through', 'text-gray-400');
                            addrEl.classList.remove('line-through', 'text-gray-400');
                        }
                    } else {
                        alert('Gagal memperbarui status cetak.');
                        this.checked = originalState;
                    }
                });
            });
        });

        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function() {
                const ids = Array.from(document.querySelectorAll('.toggle-select:checked')).map(cb => cb.getAttribute('data-id'));
                if (ids.length === 0) {
                    alert('Harap pilih data untuk dihapus.');
                    return;
                }
                
                if (confirm('Hapus ' + ids.length + ' data terpilih?')) {
                    fetch('/recipients/bulk-delete', {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify({ ids: ids })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Gagal menghapus data.');
                        }
                    }).catch(() => {
                        alert('Terjadi kesalahan jaringan.');
                    });
                }
            });
        }

        // Bulk Printed Actions
        const handleBulkPrinted = (state) => {
            const ids = Array.from(document.querySelectorAll('.toggle-select:checked')).map(cb => cb.getAttribute('data-id'));
            if (ids.length === 0) {
                alert('Harap pilih setidaknya satu data.');
                return;
            }

            const actionText = state === 1 ? 'menandai sudah cetak' : 'menandai belum cetak';
            if (confirm('Apakah Anda yakin ingin ' + actionText + ' ' + ids.length + ' data terpilih?')) {
                fetch('/recipients/bulk-printed', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ ids: ids, state: state })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Gagal memperbarui data.');
                    }
                }).catch(() => {
                    alert('Terjadi kesalahan jaringan.');
                });
            }
        };

        const bulkMarkPrintedBtn = document.getElementById('bulkMarkPrintedBtn');
        const bulkMarkNotPrintedBtn = document.getElementById('bulkMarkNotPrintedBtn');

        if (bulkMarkPrintedBtn) bulkMarkPrintedBtn.addEventListener('click', () => handleBulkPrinted(1));
        if (bulkMarkNotPrintedBtn) bulkMarkNotPrintedBtn.addEventListener('click', () => handleBulkPrinted(0));

        const printModal = new Modal(document.getElementById('print-options-modal'));
        const printLabelBtn = document.getElementById('printLabelBtn');
        const print121Link = document.getElementById('print-121-link');
        
        if (printLabelBtn) {
            printLabelBtn.addEventListener('click', function() {
                const checkedCheckboxes = document.querySelectorAll('.toggle-select:checked');
                if (checkedCheckboxes.length === 0) {
                    alert('Harap pilih setidaknya satu penerima untuk dicetak.');
                    return;
                }
                
                const selectedIds = Array.from(checkedCheckboxes).map(cb => cb.getAttribute('data-id')).join(',');
                if (print121Link) print121Link.href = `/recipients/print?type=121&ids=${selectedIds}`;
                
                printModal.show();
            });
        }

        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const [sort, dir] = this.value.split('|');
                document.getElementById('real-sort').value = sort;
                document.getElementById('real-dir').value = dir;
            });
        }

        // Edit Modal Logic
        const editModalElement = document.getElementById('edit-recipient-modal');
        const editModal = editModalElement ? new Modal(editModalElement) : null;
        
        document.querySelectorAll('.edit-recipient-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const address = this.getAttribute('data-address');
                
                const modal = document.getElementById('edit-recipient-modal');
                modal.querySelector('#edit-name').value = name;
                modal.querySelector('#edit-address').value = address;
                modal.querySelector('#edit-form').action = '/recipients/update/' + id;
                
                if (editModal) editModal.show();
            });
        });
    });
</script>

<!-- Add Recipient Modal -->
<div id="add-recipient-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Tambah Penerima</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-recipient-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="/recipients/store" method="POST" class="p-4 md:p-5 space-y-4 text-left">
                <?= csrf_field() ?>
                <div>
                    <label for="name" class="block mb-2 text-sm font-bold text-gray-900">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Masukkan nama..." required>
                </div>
                <div>
                    <label for="address" class="block mb-2 text-sm font-bold text-gray-900">Alamat / Keterangan</label>
                    <textarea id="address" name="address" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-xl border border-gray-200 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Jl. Melati No. 10, Jakarta"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="add-recipient-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Recipient Modal -->
<div id="edit-recipient-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Edit Penerima</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-recipient-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="edit-form" action="" method="POST" class="p-4 md:p-5 space-y-4 text-left">
                <?= csrf_field() ?>
                <div>
                    <label for="edit-name" class="block mb-2 text-sm font-bold text-gray-900">Nama Lengkap</label>
                    <input type="text" name="name" id="edit-name" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Masukkan nama..." required>
                </div>
                <div>
                    <label for="edit-address" class="block mb-2 text-sm font-bold text-gray-900">Alamat / Keterangan</label>
                    <textarea id="edit-address" name="address" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-xl border border-gray-200 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Jl. Melati No. 10, Jakarta"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="edit-recipient-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Print Options Modal -->
<div id="print-options-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 text-left">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-bold text-gray-900">
                    Pilih Model Label
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="print-options-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 md:p-8">
                <p class="text-sm text-gray-500 mb-6 font-medium">Pilih ukuran label stiker yang akan Anda gunakan untuk mencetak data terpilih.</p>
                <div class="grid grid-cols-1 max-w-sm mx-auto gap-4">
                    <a id="print-121-link" href="/recipients/print?type=121" target="_blank" class="flex flex-col items-center justify-center p-6 bg-emerald-50 border-2 border-emerald-100 rounded-2xl hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all group">
                        <span class="text-3xl font-black mb-2 tracking-tighter">121</span>
                        <span class="text-xs font-bold opacity-60 uppercase tracking-widest group-hover:opacity-100 transition-opacity">38 x 75 mm</span>
                    </a>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b italic text-[10px] text-gray-400">
                <i class="fa-solid fa-circle-info me-2 text-emerald-500"></i>
                Hanya data yang telah Anda centang di tabel yang akan dicetak.
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
