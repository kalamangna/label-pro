<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<?php
$currentEventName = 'Acara';
if (!empty($eventId)) {
    foreach ($events as $e) {
        if ($e['id'] == $eventId) {
            $currentEventName = $e['name'];
            break;
        }
    }
}

$urlParams = array_filter([
    'event_id' => $eventId,
    'search'   => $search,
    'status'   => $status,
    'sort'     => $sort,
    'dir'      => $dir,
], function ($val) {
    return $val !== null && $val !== '';
});
$urlQuery = !empty($urlParams) ? '?' . http_build_query($urlParams) : '';
?>
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-6">
    <div class="flex items-center gap-4">
        <div class="bg-emerald-600 p-3 rounded-2xl shadow-lg shadow-emerald-100">
            <i class="fa-solid fa-users text-white text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 leading-none mb-1">Daftar Tamu</h1>
            <p class="text-sm text-gray-500 font-medium">
                <?php if (!empty($eventId)): ?>
                    Daftar tamu untuk acara <span class="text-emerald-600 font-bold"><?= esc($currentEventName) ?></span>
                <?php else: ?>
                    Total <span class="text-emerald-600 font-bold"><?= number_format($totalInDatabase ?? 0) ?></span> tamu dalam database
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <?php if (session()->get('role') !== 'admin'): ?>
        <div class="flex gap-2 w-full sm:w-auto">
            <button id="btn-check-duplicates" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-3 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                <i class="fa-solid fa-copy me-2 text-amber-600"></i>
                Cek Duplikat
            </button>
            <?php if (!empty($eventId)): ?>                    <a href="/guests/import?event_id=<?= esc($eventId) ?>" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-3 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                        <i class="fa-solid fa-file-import me-2 text-emerald-600"></i>
                        Impor Data
                    </a>
                <?php endif; ?>

                <button data-modal-target="add-guest-modal" data-modal-toggle="add-guest-modal" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                    <i class="fa-solid fa-plus me-2"></i>
                    Tambah
                </button>
            </div>
        <?php endif; ?>
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
    <form action="/guests" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-x-4 gap-y-5">
        <!-- Search -->
        <div class="md:col-span-6">
            <label class="block mb-2 text-[10px] font-black uppercase tracking-widest text-slate-500 ps-1">Cari Nama / Jabatan / Alamat</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" class="block w-full ps-9 text-sm text-gray-900 border border-slate-300 rounded-xl bg-white focus:ring-emerald-500 focus:border-emerald-500 h-[42px] transition-all placeholder-slate-400" placeholder="Ketik pencarian...">
            </div>
        </div>

        <!-- Status Filter -->
        <div class="md:col-span-3">
            <label class="block mb-2 text-[10px] font-black uppercase tracking-widest text-slate-500 ps-1">Status</label>
            <select name="status" class="bg-white border border-slate-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full h-[42px] px-2.5 transition-all">
                <option value="">Semua Status</option>
                <option value="0" <?= (string)($status ?? '') === '0' ? 'selected' : '' ?>>Belum Dicetak</option>
                <option value="1" <?= (string)($status ?? '') === '1' ? 'selected' : '' ?>>Sudah Dicetak</option>
            </select>
        </div>

        <?php if (!empty($eventId)): ?>
            <input type="hidden" name="event_id" value="<?= esc($eventId) ?>">
        <?php endif; ?>

        <!-- Sort Filter -->
        <div class="md:col-span-3">
            <label class="block mb-2 text-[10px] font-black uppercase tracking-widest text-slate-500 ps-1">Urutan</label>
            <select id="sort-select" class="bg-white border border-slate-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full h-[42px] px-2.5 transition-all">
                <option value="id|desc" <?= ($sort == 'id' && $dir == 'desc') ? 'selected' : '' ?>>Terbaru</option>
                <option value="id|asc" <?= ($sort == 'id' && $dir == 'asc') ? 'selected' : '' ?>>Terlama</option>
                <option value="name|asc" <?= ($sort == 'name' && $dir == 'asc') ? 'selected' : '' ?>>Nama: A-Z</option>
                <option value="name|desc" <?= ($sort == 'name' && $dir == 'desc') ? 'selected' : '' ?>>Nama: Z-A</option>
                <option value="address|asc" <?= ($sort == 'address' && $dir == 'asc') ? 'selected' : '' ?>>Alamat: A-Z</option>
                <option value="address|desc" <?= ($sort == 'address' && $dir == 'desc') ? 'selected' : '' ?>>Alamat: Z-A</option>
            </select>
            <input type="hidden" name="sort" id="real-sort" value="<?= esc($sort ?? 'id') ?>">
            <input type="hidden" name="dir" id="real-dir" value="<?= esc($dir ?? 'desc') ?>">
        </div>

        <!-- Buttons & Results Info -->
        <div class="md:col-span-12 flex flex-col md:flex-row items-center justify-between gap-4 mt-2 pt-4 border-t border-gray-200/60">
            <div class="text-xs font-bold text-slate-500">
                <?php
                $activeFilters = [];
                if (!empty($search)) $activeFilters[] = "Pencarian: '" . esc($search) . "'";
                if (($status ?? '') !== '') $activeFilters[] = "Status: " . ($status == '1' ? 'Sudah Dicetak' : 'Belum Dicetak');
                if (!empty($eventId)) {
                    $currentEventName = 'Acara';
                    foreach ($events as $e) {
                        if ($e['id'] == $eventId) {
                            $currentEventName = $e['name'];
                            break;
                        }
                    }
                    $activeFilters[] = "Acara: " . esc($currentEventName);
                }
                ?>
                <?php if (!empty($activeFilters)): ?>
                    Ditemukan <span class="text-emerald-600"><?= number_format($pager->getTotal()) ?></span> data untuk
                    <span class="text-emerald-700 italic"><?= implode(', ', $activeFilters) ?></span>
                <?php endif; ?>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <?php if (!empty($search) || ($status ?? '') !== '' || ($sort ?? 'id') !== 'id' || !empty($eventId)): ?>
                    <a href="/guests<?= !empty($eventId) ? '?event_id=' . esc($eventId) : '' ?>" class="flex-1 md:w-32 h-[42px] flex items-center justify-center bg-white border border-slate-300 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all active:scale-95 text-center">Reset</a>
                <?php endif; ?>
                <button type="submit" class="flex-1 md:w-32 h-[42px] bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 focus:ring-4 focus:ring-slate-200 transition-all active:scale-95 shadow-md shadow-slate-200 flex items-center justify-center">Filter</button>
            </div>
        </div>
    </form>
</div>

<!-- Bulk Actions Bar -->
<?php if (session()->get('role') !== 'admin'): ?>
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
<?php endif; ?>

<!-- Table -->
<div class="relative overflow-x-auto border border-gray-100 sm:rounded-2xl shadow-sm bg-white">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">
            <tr>
                <?php if (session()->get('role') !== 'admin'): ?>
                    <th scope="col" class="p-4 w-4 text-center">
                        <input id="select-all" type="checkbox" class="w-4 h-4 text-emerald-600 bg-white border-gray-200 rounded focus:ring-emerald-500 cursor-pointer">
                    </th>
                <?php endif; ?>
                <th scope="col" class="px-6 py-4 font-bold">Nama Tamu</th>
                <th scope="col" class="px-6 py-4 font-bold">Jabatan</th>
                <th scope="col" class="px-6 py-4 font-bold">Alamat</th>
                <th scope="col" class="px-6 py-4 font-bold whitespace-nowrap">Acara</th>
                <?php if (session()->get('role') === 'admin'): ?>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Ditambahkan Oleh</th>
                <?php endif; ?>
                <th scope="col" class="px-6 py-4 text-center font-bold whitespace-nowrap">Status Cetak</th>
                <?php if (session()->get('role') !== 'admin'): ?>
                    <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($guests as $guest): ?>
                <tr id="row-<?= $guest['id'] ?>" class="bg-white hover:bg-emerald-50/30 transition-colors <?= ($guest['is_printed'] ?? 0) ? 'bg-gray-50/30' : '' ?>">
                    <?php if (session()->get('role') !== 'admin'): ?>
                        <td class="p-4 text-center">
                            <input type="checkbox" class="w-4 h-4 text-emerald-600 bg-white border-gray-200 rounded focus:ring-emerald-500 cursor-pointer toggle-select" data-id="<?= $guest['id'] ?>" <?= ($guest['is_selected'] ?? 0) ? 'checked' : '' ?>>
                        </td>
                    <?php endif; ?>
                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 <?= ($guest['is_printed'] ?? 0) ? 'line-through text-gray-400 font-medium' : '' ?>">
                        <?= esc($guest['name']) ?>
                    </th>
                    <td class="px-6 py-4 <?= ($guest['is_printed'] ?? 0) ? 'line-through text-gray-400 font-medium' : 'text-gray-600 font-medium' ?>">
                        <?= !empty(trim((string)($guest['position'] ?? ''))) ? esc($guest['position']) : '-' ?>
                    </td>
                    <td class="px-6 py-4 <?= ($guest['is_printed'] ?? 0) ? 'line-through text-gray-400 font-medium' : 'text-gray-600 font-medium' ?>">
                        <div class="line-clamp-1"><?= esc($guest['address']) ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-xs font-medium text-gray-500">
                            <i class="fa-solid fa-folder me-1 text-[10px] opacity-40"></i>
                            <?= esc($guest['event_name'] ?? 'Tanpa Acara') ?>
                        </span>
                    </td>
                    <?php if (session()->get('role') === 'admin'): ?>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                                <i class="fa-solid fa-user me-1.5 text-[10px] opacity-50"></i>
                                <?= esc($guest['added_by'] ?? 'Sistem') ?>
                            </span>
                        </td>
                    <?php endif; ?>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <?php if ($guest['is_printed'] ?? 0): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <i class="fa-solid fa-check me-1.5 text-[10px]"></i>
                                Sudah
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                Belum
                            </span>
                        <?php endif; ?>
                    </td>
                    <?php if (session()->get('role') !== 'admin'): ?>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button type="button" class="p-2 text-gray-400 hover:text-emerald-600 transition-colors edit-guest-btn"
                                    data-id="<?= $guest['id'] ?>"
                                    data-name="<?= esc($guest['name']) ?>"
                                    data-position="<?= esc($guest['position'] ?? '') ?>"
                                    data-address="<?= esc($guest['address']) ?>"
                                    data-event-id="<?= $guest['event_id'] ?>"
                                    data-is-printed="<?= $guest['is_printed'] ?? 0 ?>"
                                    title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button type="button" data-modal-target="delete-modal-<?= $guest['id'] ?>" data-modal-toggle="delete-modal-<?= $guest['id'] ?>" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div id="delete-modal-<?= $guest['id'] ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 text-left">
                                        <div class="p-6 text-center">
                                            <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                                            </div>
                                            <h3 class="mb-2 text-lg font-bold text-gray-900">Hapus data ini?</h3>
                                            <p class="mb-6 text-sm text-gray-500 italic">"<?= esc($guest['name']) ?>"</p>
                                            <div class="flex justify-center gap-3">
                                                <button data-modal-hide="delete-modal-<?= $guest['id'] ?>" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                                                <a href="/guests/delete/<?= $guest['id'] ?><?= $urlQuery ?>" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-100">Hapus Data</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($guests)): ?>
                <tr>
                    <td colspan="<?= session()->get('role') === 'admin' ? '5' : '6' ?>" class="px-6 py-16 text-center bg-gray-50/30 text-gray-400 font-medium">
                        <div class="max-w-xs mx-auto text-center">
                            <i class="fa-solid fa-inbox text-4xl mb-4 opacity-20 text-emerald-600"></i>
                            <p class="text-sm font-bold text-gray-900 mb-1">Belum ada data</p>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <p class="text-xs text-gray-500 leading-relaxed">Sistem belum memiliki data tamu yang ditambahkan oleh pengguna.</p>
                            <?php else: ?>
                                <p class="text-xs text-gray-500 leading-relaxed">Gunakan tombol Tambah atau Impor untuk mengisi daftar tamu label Anda.</p>
                            <?php endif; ?>
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

<?php if (session()->get('role') !== 'admin'): ?>
    <!-- Sticky Selection Toolbar -->
    <div id="selection-toolbar" class="<?= ($selectedCount ?? 0) > 0 ? 'flex' : 'hidden' ?> fixed bottom-0 left-0 w-full z-50 items-center justify-between px-6 py-4 bg-slate-900 shadow-[0_-10px_40px_rgba(0,0,0,0.2)] border-t border-slate-700 text-white transition-all duration-300">
        <div class="flex items-center gap-3">
            <div class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500 text-sm font-bold" id="selected-count-badge"><?= esc($selectedCount ?? 0) ?></div>
            <span class="text-base font-medium">Tamu Terpilih</span>
        </div>
        <div class="flex gap-3">
            <button type="button" id="clearSelectionBtn" class="text-sm font-bold text-slate-300 hover:text-white transition-colors px-3 py-2 border border-transparent hover:border-slate-700 rounded-xl">Batal</button>
            <button type="button" id="openPrintModalBtn" class="text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-900 px-6 py-2 rounded-xl transition-colors shadow-lg shadow-amber-900/20">
                <i class="fa-solid fa-print me-2"></i> Cetak Label
            </button>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const headers = {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        };

        const selectAllCheckbox = document.getElementById('select-all');
        const selectCheckboxes = document.querySelectorAll('.toggle-select');
        const selectionToolbar = document.getElementById('selection-toolbar');
        const countBadge = document.getElementById('selected-count-badge');

        function updateToolbar(count, unprintedCount) {
            if (countBadge) countBadge.textContent = count;
            if (selectionToolbar) {
                if (count > 0) {
                    selectionToolbar.classList.remove('hidden');
                    selectionToolbar.classList.add('flex');
                } else {
                    selectionToolbar.classList.add('hidden');
                    selectionToolbar.classList.remove('flex');
                }
            }

            // Update Print Modal Warnings
            const unprintedWarning = document.getElementById('unprinted-selected-count-warning');
            const unprintedWarningContainer = document.getElementById('unprinted-selected-count-warning-container');
            if (unprintedWarning) unprintedWarning.textContent = unprintedCount;
            if (unprintedWarningContainer) {
                if (unprintedCount > 10) {
                    unprintedWarningContainer.classList.remove('hidden');
                    unprintedWarningContainer.classList.add('flex');
                } else {
                    unprintedWarningContainer.classList.add('hidden');
                    unprintedWarningContainer.classList.remove('flex');
                }
            }

            const printedExcludedCountEl = document.getElementById('printed-excluded-count');
            const printedExcludedWarning = document.getElementById('printed-excluded-warning');
            if (printedExcludedCountEl && printedExcludedWarning) {
                const excludedCount = count - unprintedCount;
                printedExcludedCountEl.textContent = excludedCount;
                if (excludedCount > 0) {
                    printedExcludedWarning.classList.remove('hidden');
                    printedExcludedWarning.classList.add('flex');
                } else {
                    printedExcludedWarning.classList.add('hidden');
                    printedExcludedWarning.classList.remove('flex');
                }
            }

            const noUnprintedWarning = document.getElementById('no-unprinted-warning');
            if (noUnprintedWarning) {
                if (unprintedCount === 0 && count > 0) {
                    noUnprintedWarning.classList.remove('hidden');
                    noUnprintedWarning.classList.add('flex');
                } else {
                    noUnprintedWarning.classList.add('hidden');
                    noUnprintedWarning.classList.remove('flex');
                }
            }
        }

        function updateSelectAllState() {
            const checkedCount = document.querySelectorAll('.toggle-select:checked').length;
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = checkedCount === selectCheckboxes.length && checkedCount > 0;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < selectCheckboxes.length;
            }
        }

        selectCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                const originalState = !this.checked;

                fetch(`/guests/toggle-selection/${id}`, {
                    method: 'POST',
                    headers: headers,
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        updateToolbar(data.count, data.unprinted_count);
                        updateSelectAllState();
                    } else {
                        if (data.limit_reached || data.message) alert(data.message || 'Gagal memperbarui status pilihan.');
                        else alert('Gagal memperbarui status pilihan.');
                        this.checked = originalState;
                        updateSelectAllState();
                    }
                }).catch(() => {
                    alert('Terjadi kesalahan jaringan.');
                    this.checked = originalState;
                    updateSelectAllState();
                });
            });
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                const ids = Array.from(selectCheckboxes).map(cb => cb.getAttribute('data-id'));
                const action = isChecked ? 'select' : 'deselect';

                fetch('/guests/bulk-toggle-selection', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({
                        ids: ids,
                        action: action
                    })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        updateToolbar(data.count, data.unprinted_count);
                        selectCheckboxes.forEach(cb => cb.checked = isChecked);
                        updateSelectAllState();
                    } else {
                        if (data.limit_reached || data.message) alert(data.message || 'Gagal memperbarui status pilihan.');
                        else alert('Gagal memperbarui status pilihan.');
                        this.checked = !isChecked;
                    }
                }).catch(() => {
                    alert('Terjadi kesalahan jaringan.');
                    this.checked = !isChecked;
                });
            });
        }

        const clearSelectionBtn = document.getElementById('clearSelectionBtn');
        if (clearSelectionBtn) {
            clearSelectionBtn.addEventListener('click', function() {
                fetch('/guests/clear-selection', {
                    method: 'POST',
                    headers: headers,
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
            });
        }

        updateSelectAllState();

        const bulkDeleteModalEl = document.getElementById('bulk-delete-modal');
        const bulkDeleteModal = bulkDeleteModalEl ? new Modal(bulkDeleteModalEl) : null;

        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function() {
                const ids = Array.from(document.querySelectorAll('.toggle-select:checked')).map(cb => cb.getAttribute('data-id'));
                if (ids.length === 0) {
                    alert('Harap pilih data untuk dihapus.');
                    return;
                }

                const countEl = document.getElementById('bulk-delete-count');
                if (countEl) countEl.innerText = ids.length;
                if (bulkDeleteModal) bulkDeleteModal.show();
            });
        }

        const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
        if (confirmBulkDeleteBtn) {
            confirmBulkDeleteBtn.addEventListener('click', function() {
                const ids = Array.from(document.querySelectorAll('.toggle-select:checked')).map(cb => cb.getAttribute('data-id'));
                fetch('/guests/bulk-delete', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({
                        ids: ids
                    })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        fetch('/guests/clear-selection', {
                                method: 'POST',
                                headers: headers
                            })
                            .finally(() => window.location.reload());
                    } else {
                        alert('Gagal menghapus data.');
                    }
                }).catch(() => {
                    alert('Terjadi kesalahan jaringan.');
                });
            });
        }

        const bulkStatusModalEl = document.getElementById('bulk-status-modal');
        const bulkStatusModal = bulkStatusModalEl ? new Modal(bulkStatusModalEl) : null;
        let pendingStatusState = null;

        // Bulk Printed Actions
        const handleBulkPrinted = (state) => {
            const ids = Array.from(document.querySelectorAll('.toggle-select:checked')).map(cb => cb.getAttribute('data-id'));
            if (ids.length === 0) {
                alert('Harap pilih setidaknya satu data.');
                return;
            }

            pendingStatusState = state;
            const titleEl = document.getElementById('bulk-status-title');
            const countEl = document.getElementById('bulk-status-count');
            const descEl = document.getElementById('bulk-status-desc');
            const iconContainer = document.getElementById('bulk-status-icon-container');
            const icon = document.getElementById('bulk-status-icon');
            const confirmBtn = document.getElementById('confirmBulkStatusBtn');

            if (countEl) countEl.innerText = ids.length;

            if (state === 1) {
                if (titleEl) titleEl.innerText = 'Tandai sudah cetak';
                if (descEl) descEl.innerText = 'Data terpilih akan ditandai sebagai sudah dicetak (coret).';
                if (iconContainer) iconContainer.className = 'w-10 h-10 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4';
                if (icon) icon.className = 'fa-solid fa-check-double text-xl';
                if (confirmBtn) {
                    confirmBtn.innerText = 'Sudah Cetak';
                    confirmBtn.className = 'px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100';
                }
            } else {
                if (titleEl) titleEl.innerText = 'Tandai belum cetak';
                if (descEl) descEl.innerText = 'Data terpilih akan dikembalikan ke status belum dicetak.';
                if (iconContainer) iconContainer.className = 'w-10 h-10 bg-slate-50 text-slate-600 rounded-full flex items-center justify-center mx-auto mb-4';
                if (icon) icon.className = 'fa-solid fa-rotate-left text-xl';
                if (confirmBtn) {
                    confirmBtn.innerText = 'Belum Cetak';
                    confirmBtn.className = 'px-5 py-2.5 text-sm font-bold text-white bg-slate-600 rounded-xl hover:bg-slate-700 transition-all shadow-lg shadow-slate-100';
                }
            }

            if (bulkStatusModal) bulkStatusModal.show();
        };

        const confirmBulkStatusBtn = document.getElementById('confirmBulkStatusBtn');
        if (confirmBulkStatusBtn) {
            confirmBulkStatusBtn.addEventListener('click', function() {
                const ids = Array.from(document.querySelectorAll('.toggle-select:checked')).map(cb => cb.getAttribute('data-id'));
                fetch('/guests/bulk-printed', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({
                        ids: ids,
                        state: pendingStatusState
                    })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        fetch('/guests/clear-selection', {
                                method: 'POST',
                                headers: headers
                            })
                            .finally(() => window.location.reload());
                    } else {
                        alert('Gagal memperbarui data.');
                    }
                }).catch(() => {
                    alert('Terjadi kesalahan jaringan.');
                });
            });
        }

        const bulkMarkPrintedBtn = document.getElementById('bulkMarkPrintedBtn');
        const bulkMarkNotPrintedBtn = document.getElementById('bulkMarkNotPrintedBtn');

        if (bulkMarkPrintedBtn) bulkMarkPrintedBtn.addEventListener('click', () => handleBulkPrinted(1));
        if (bulkMarkNotPrintedBtn) bulkMarkNotPrintedBtn.addEventListener('click', () => handleBulkPrinted(0));

        const printModal = new Modal(document.getElementById('print-options-modal'));
        const openPrintModalBtn = document.getElementById('openPrintModalBtn');
        const print121Link = document.getElementById('print-121-link');
        const printOffsetInput = document.getElementById('print-offset');
        const printAlignInput = document.getElementById('print-align');

        function updatePrintLink() {
            if (print121Link && printOffsetInput) {
                let offset = parseInt(printOffsetInput.value) || 1;
                if (offset < 1) offset = 1;
                if (offset > 10) offset = 10;

                let align = printAlignInput ? printAlignInput.value : 'center';
                print121Link.href = `/guests/print?type=121&offset=${offset - 1}&align=${align}`;

                const alignImg = document.getElementById('align-preview-img');
                if (alignImg) {
                    if (align === 'flex-start') alignImg.src = '/img/kiri.svg';
                    else if (align === 'flex-end') alignImg.src = '/img/kanan.svg';
                    else alignImg.src = '/img/tengah.svg';
                }
            }
        }

        if (printOffsetInput) {
            printOffsetInput.addEventListener('input', updatePrintLink);
            printOffsetInput.addEventListener('change', updatePrintLink);
        }

        if (printAlignInput) {
            printAlignInput.addEventListener('change', updatePrintLink);
        }

        function openPrintModal() {
            const unprintedWarning = document.getElementById('unprinted-selected-count-warning');
            const unprintedCount = unprintedWarning ? parseInt(unprintedWarning.textContent) || 0 : 0;

            if (unprintedCount === 0) {
                alert('Tidak ada data baru (belum dicetak) yang dipilih. Harap pilih data yang belum dicetak untuk melanjutkan.');
                return;
            }

            if (printOffsetInput) printOffsetInput.value = 1;
            if (printAlignInput) printAlignInput.value = 'center';
            updatePrintLink();
            printModal.show();
        }

        if (openPrintModalBtn) {
            openPrintModalBtn.addEventListener('click', function() {
                openPrintModal();
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
        const editModalElement = document.getElementById('edit-guest-modal');
        const editModal = editModalElement ? new Modal(editModalElement) : null;

        document.querySelectorAll('.edit-guest-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const position = this.getAttribute('data-position');
                const address = this.getAttribute('data-address');
                const eventId = this.getAttribute('data-event-id');
                const isPrinted = this.getAttribute('data-is-printed');

                const modal = document.getElementById('edit-guest-modal');
                modal.querySelector('#edit-name').value = name;
                modal.querySelector('#edit-position').value = position || '';
                modal.querySelector('#edit-address').value = address;
                modal.querySelector('#edit-event-id').value = eventId || '';

                if (isPrinted == '1') {
                    modal.querySelector('#edit-status-sudah').checked = true;
                } else {
                    modal.querySelector('#edit-status-belum').checked = true;
                }

                modal.querySelector('#edit-form').action = '/guests/update/' + id;

                if (editModal) editModal.show();
            });
        });
        // Image Fullscreen Preview Logic
        const fullscreenModalEl = document.getElementById('image-fullscreen-modal');
        const fullscreenModal = new Modal(fullscreenModalEl);
        const fullscreenImg = document.getElementById('fullscreen-preview-img');
        const previewTitle = document.getElementById('preview-modal-title');

        document.querySelectorAll('.img-preview-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                fullscreenImg.src = this.src;
                previewTitle.textContent = this.getAttribute('data-title') || 'Preview';
                fullscreenModal.show();
            });
        });

        document.querySelectorAll('[data-modal-hide="image-fullscreen-modal"]').forEach(btn => {
            btn.addEventListener('click', () => fullscreenModal.hide());
        });

        // Duplicate Checker Logic
        const duplicateModalEl = document.getElementById('duplicate-check-modal');
        const duplicateModal = duplicateModalEl ? new Modal(duplicateModalEl) : null;
        const btnCheckDuplicates = document.getElementById('btn-check-duplicates');
        const duplicateListContainer = document.getElementById('duplicate-list-container');
        const duplicateLoading = document.getElementById('duplicate-loading');

        if (btnCheckDuplicates && duplicateModal) {
            btnCheckDuplicates.addEventListener('click', () => {
                duplicateModal.show();
                duplicateLoading.classList.remove('hidden');
                duplicateListContainer.innerHTML = '';
                
                const eventParam = <?= !empty($eventId) ? "'" . esc($eventId) . "'" : "''" ?>;
                const url = eventParam ? `/guests/scan-duplicates?event_id=${eventParam}` : '/guests/scan-duplicates';

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    duplicateLoading.classList.add('hidden');
                    if (data.success && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(group => {
                            html += `
                                <div class="mb-6 bg-gray-50 border border-gray-200 rounded-2xl p-4 shadow-sm">
                                    <h4 class="font-bold text-gray-900 mb-3 flex items-center justify-between">
                                        <span><i class="fa-solid fa-users me-2 text-amber-500"></i> ${group.name}</span>
                                        <span class="bg-amber-100 text-amber-800 text-[10px] uppercase tracking-widest px-2.5 py-1 rounded-lg border border-amber-200 font-black">${group.count} Data</span>
                                    </h4>
                                    <div class="space-y-3">
                            `;
                            group.items.forEach(item => {
                                html += `
                                    <div class="flex items-start justify-between bg-white p-3 rounded-xl border border-gray-100 shadow-sm" id="duplicate-item-${item.id}">
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">${item.name}</p>
                                            <p class="text-xs text-gray-500 mt-1"><span class="font-medium text-gray-700">Jabatan:</span> ${item.position || '-'}</p>
                                            <p class="text-xs text-gray-500 mt-1"><span class="font-medium text-gray-700">Alamat:</span> <span class="line-clamp-1">${item.address || '-'}</span></p>
                                            <p class="text-xs mt-2">
                                                <span class="font-medium text-gray-700">Status:</span> 
                                                ${item.is_printed == 1 
                                                    ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 ml-1"><i class="fa-solid fa-check me-1"></i>Sudah Cetak</span>' 
                                                    : '<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 ml-1">Belum Cetak</span>'}
                                                ${item.similarity_score ? `<span class="ms-2 text-[10px] font-medium text-slate-400 italic">Skor: ${item.similarity_score}%</span>` : ''}
                                            </p>
                                        </div>
                                        <div class="flex flex-col gap-2 mt-1">
                                            <button type="button" class="btn-edit-duplicate flex-shrink-0 text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 focus:ring-4 focus:ring-emerald-50 font-bold rounded-lg text-[10px] px-3 py-1.5 transition-all" 
                                                    data-id="${item.id}" 
                                                    data-name="${item.name}" 
                                                    data-jabatan="${item.position || ''}" 
                                                    data-address="${item.address || ''}" 
                                                    data-event-id="${item.event_id || ''}" 
                                                    data-is-printed="${item.is_printed}">
                                                <i class="fa-solid fa-pen-to-square me-1.5"></i> Edit
                                            </button>
                                            <button type="button" class="btn-delete-duplicate flex-shrink-0 text-red-500 bg-red-50 hover:bg-red-100 border border-red-100 focus:ring-4 focus:ring-red-50 font-bold rounded-lg text-[10px] px-3 py-1.5 transition-all" data-id="${item.id}">
                                                <i class="fa-solid fa-trash-can me-1.5"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                `;
                            });
                            html += `</div></div>`;
                        });
                        duplicateListContainer.innerHTML = html;

                        // Attach edit handlers
                        document.querySelectorAll('.btn-edit-duplicate').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const id = this.getAttribute('data-id');
                                const name = this.getAttribute('data-name');
                                const jabatan = this.getAttribute('data-jabatan');
                                const address = this.getAttribute('data-address');
                                const eventId = this.getAttribute('data-event-id');
                                const isPrinted = this.getAttribute('data-is-printed');

                                const modal = document.getElementById('edit-guest-modal');
                                modal.querySelector('#edit-name').value = name;
                                modal.querySelector('#edit-position').value = jabatan || '';
                                modal.querySelector('#edit-address').value = address;
                                modal.querySelector('#edit-event-id').value = eventId || '';
                                
                                if (isPrinted == '1') {
                                    modal.querySelector('#edit-status-sudah').checked = true;
                                } else {
                                    modal.querySelector('#edit-status-belum').checked = true;
                                }

                                modal.querySelector('#edit-form').action = '/guests/update/' + id;

                                // Hide duplicate modal and show edit modal
                                if (duplicateModal) duplicateModal.hide();
                                if (editModal) editModal.show();
                            });
                        });
                        
                        // Attach delete handlers
                        document.querySelectorAll('.btn-delete-duplicate').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const id = this.getAttribute('data-id');
                                if (confirm('Yakin ingin menghapus data duplikat ini?')) {
                                    fetch('/guests/bulk-delete', {
                                        method: 'POST',
                                        headers: headers,
                                        body: JSON.stringify({ ids: [id] })
                                    })
                                    .then(res => res.json())
                                    .then(delData => {
                                        if (delData.success) {
                                            document.getElementById(`duplicate-item-${id}`).remove();
                                        } else {
                                            alert('Gagal menghapus data.');
                                        }
                                    });
                                }
                            });
                        });
                    } else if (data.success && data.data.length === 0) {
                        duplicateListContainer.innerHTML = `
                            <div class="text-center py-10">
                                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-check-double text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Bebas Duplikat</h4>
                                <p class="text-sm text-gray-500">Tidak ditemukan data yang terindikasi mirip atau ganda.</p>
                            </div>
                        `;
                    } else {
                        duplicateListContainer.innerHTML = `
                            <div class="text-center py-10">
                                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-circle-exclamation text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Gagal Memeriksa</h4>
                                <p class="text-sm text-gray-500">${data.message || 'Terjadi kesalahan saat memproses data.'}</p>
                            </div>
                        `;
                    }
                })
                .catch((e) => {
                    console.error(e);
                    duplicateLoading.classList.add('hidden');
                    alert('Terjadi kesalahan saat mengambil data.');
                });
            });
        }
    });
</script>

<!-- Add Guest Modal -->
<div id="add-guest-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Tambah Tamu</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-guest-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="/guests/store" method="POST" class="p-4 md:p-5 space-y-4 text-left">
                <?= csrf_field() ?>
                <div>
                    <label for="name" class="block mb-2 text-sm font-bold text-gray-900">Nama</label>
                    <input type="text" name="name" id="name" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Masukkan nama..." required>
                </div>
                <div>
                    <label for="position" class="block mb-2 text-sm font-bold text-gray-900">Jabatan (Opsional)</label>
                    <input type="text" name="position" id="position" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Contoh: Bapak, Ibu, Direktur...">
                </div>
                <div>
                    <label for="address" class="block mb-2 text-sm font-bold text-gray-900">Alamat (Opsional)</label>
                    <textarea id="address" name="address" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-xl border border-gray-200 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Jl. Melati No. 10, Jakarta"></textarea>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-900">Acara</label>
                    <?php if (!empty($eventId)): ?>
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-xl block w-full p-2.5">
                            <i class="fa-solid fa-folder me-2 text-emerald-600"></i>
                            <?= esc($currentEventName) ?>
                        </div>
                        <input type="hidden" name="event_id" value="<?= esc($eventId) ?>">
                    <?php else: ?>
                        <select name="event_id" id="event_id" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                            <option value="">Tanpa Acara</option>
                            <?php foreach ($events as $event): ?>
                                <option value="<?= $event['id'] ?>" <?= (string)($eventId ?? '') === (string)$event['id'] ? 'selected' : '' ?>><?= esc($event['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="add-guest-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Guest Modal -->
<div id="edit-guest-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Edit Tamu</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-guest-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="edit-form" action="" method="POST" class="p-4 md:p-5 space-y-4 text-left">
                <?= csrf_field() ?>
                <input type="hidden" name="current_search" value="<?= esc($search ?? '') ?>">
                <input type="hidden" name="current_status" value="<?= esc($status ?? '') ?>">
                <input type="hidden" name="current_sort" value="<?= esc($sort ?? '') ?>">
                <input type="hidden" name="current_dir" value="<?= esc($dir ?? '') ?>">
                <div>
                    <label for="edit-name" class="block mb-2 text-sm font-bold text-gray-900">Nama</label>
                    <input type="text" name="name" id="edit-name" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Masukkan nama..." required>
                </div>
                <div>
                    <label for="edit-position" class="block mb-2 text-sm font-bold text-gray-900">Jabatan (Opsional)</label>
                    <input type="text" name="position" id="edit-position" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Contoh: Bapak, Ibu, Direktur...">
                </div>
                <div>
                    <label for="edit-address" class="block mb-2 text-sm font-bold text-gray-900">Alamat (Opsional)</label>
                    <textarea id="edit-address" name="address" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-xl border border-gray-200 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Jl. Melati No. 10, Jakarta"></textarea>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-900">Acara</label>
                    <?php if (!empty($eventId)): ?>
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-xl block w-full p-2.5">
                            <i class="fa-solid fa-folder me-2 text-emerald-600"></i>
                            <?= esc($currentEventName) ?>
                        </div>
                        <input type="hidden" name="event_id" id="edit-event-id" value="<?= esc($eventId) ?>">
                    <?php else: ?>
                        <select name="event_id" id="edit-event-id" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                            <option value="">Tanpa Acara</option>
                            <?php foreach ($events as $event): ?>
                                <option value="<?= $event['id'] ?>"><?= esc($event['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block mb-3 text-sm font-bold text-gray-900">Status Cetak</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100 transition-all peer-checked:bg-emerald-50 peer-checked:border-emerald-200">
                            <input id="edit-status-belum" type="radio" value="0" name="is_printed" class="w-4 h-4 text-emerald-600 bg-white border-gray-300 focus:ring-emerald-500">
                            <span class="ms-2 text-sm font-bold text-gray-700">Belum</span>
                        </label>
                        <label class="flex items-center px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100 transition-all peer-checked:bg-emerald-50 peer-checked:border-emerald-200">
                            <input id="edit-status-sudah" type="radio" value="1" name="is_printed" class="w-4 h-4 text-emerald-600 bg-white border-gray-300 focus:ring-emerald-500">
                            <span class="ms-2 text-sm font-bold text-gray-700">Sudah</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="edit-guest-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div id="bulk-delete-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 text-left">
            <div class="p-6 text-center">
                <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900">Hapus <span id="bulk-delete-count">0</span> data terpilih?</h3>
                <p class="mb-6 text-sm text-gray-500 italic">Tindakan ini tidak dapat dibatalkan dan data akan terhapus permanen.</p>
                <div class="flex justify-center gap-3">
                    <button data-modal-hide="bulk-delete-modal" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button id="confirmBulkDeleteBtn" type="button" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-100">Hapus Data</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Status Modal -->
<div id="bulk-status-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 text-left">
            <div class="p-6 text-center">
                <div id="bulk-status-icon-container" class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i id="bulk-status-icon" class="fa-solid text-xl"></i>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900"><span id="bulk-status-title">Perbarui</span> <span id="bulk-status-count">0</span> data?</h3>
                <p class="mb-6 text-sm text-gray-500 italic" id="bulk-status-desc">Tindakan ini akan mengubah status cetak pada data terpilih.</p>
                <div class="flex justify-center gap-3">
                    <button data-modal-hide="bulk-status-modal" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button id="confirmBulkStatusBtn" type="button" class="px-5 py-2.5 text-sm font-bold text-white rounded-xl transition-all shadow-lg"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Options Modal -->
<div id="print-options-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 text-left">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-bold text-gray-900">
                    Pilih Model Label
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="print-options-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 md:p-8">
                <div class="space-y-10">
                    <!-- Section 1: Settings -->
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-sm">1</div>
                            <h4 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider">Pengaturan Posisi & Perataan</h4>
                        </div>

                        <div class="grid grid-cols-2 gap-x-8 gap-y-4 items-start">
                            <!-- Row 1: Inputs -->
                            <div>
                                <label for="print-offset" class="block mb-2 text-sm font-bold text-gray-900">Mulai cetak dari posisi ke-</label>
                                <input type="number" id="print-offset" min="1" max="10" value="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="1-10" required>
                            </div>

                            <div>
                                <label for="print-align" class="block mb-2 text-sm font-bold text-gray-900">Perataan Horizontal</label>
                                <select id="print-align" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                                    <option value="center">Tengah (Default)</option>
                                    <option value="flex-start">Kiri</option>
                                    <option value="flex-end">Kanan</option>
                                </select>
                            </div>

                            <!-- Row 2: Visualizations -->
                            <div class="bg-emerald-50/50 rounded-2xl p-4 border border-emerald-100 flex flex-col items-center justify-center h-40 overflow-hidden relative">
                                <span class="absolute top-2 left-3 text-[10px] font-bold text-emerald-800 uppercase tracking-widest z-10">Panduan Posisi</span>
                                <img src="/img/posisi.svg" alt="Panduan Posisi" class="h-full w-full object-contain mt-4 cursor-pointer hover:scale-105 transition-transform duration-300 img-preview-trigger" data-title="Panduan Posisi">
                            </div>
                            <div class="bg-emerald-50/50 rounded-2xl p-4 border border-emerald-100 flex flex-col items-center justify-center h-40 overflow-hidden relative">
                                <span class="absolute top-2 left-3 text-[10px] font-bold text-emerald-800 uppercase tracking-widest z-10">Pratinjau Perataan</span>
                                <img id="align-preview-img" src="/img/tengah.svg" alt="Panduan Perataan" class="h-full w-full object-contain mt-4 cursor-pointer hover:scale-105 transition-transform duration-300 img-preview-trigger" data-title="Pratinjau Perataan">
                            </div>

                            <!-- Helper Texts -->
                            <p class="text-[11px] text-gray-500 italic leading-relaxed">Bermanfaat jika Anda menggunakan kertas stiker yang sudah sebagian terpakai.</p>
                            <p class="text-[11px] text-gray-500 italic leading-relaxed">Sesuaikan dengan posisi masuk kertas pada printer Anda.</p>
                        </div>
                    </section>

                    <!-- Section 2: Model & Action -->
                    <section class="pt-8 border-t border-gray-100 text-left">
                        <div class="flex items-center justify-start gap-3 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-sm">2</div>
                            <h4 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider">Pilih Model & Cetak</h4>
                        </div>

                        <div class="grid grid-cols-1 max-w-xs">
                            <a id="print-121-link" href="/guests/print?type=121" target="_blank" class="flex flex-col items-center justify-center p-6 bg-emerald-50 border-2 border-emerald-100 rounded-3xl hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all group shadow-xl shadow-emerald-900/5 hover:-translate-y-1">
                                <span class="text-4xl font-black mb-1 tracking-tighter">121</span>
                                <span class="text-[10px] font-black opacity-60 uppercase tracking-[0.2em] group-hover:opacity-100 transition-opacity">38x75mm</span>
                                <div class="mt-4 flex items-center text-xs font-bold">
                                    Buka Pratinjau <i class="fa-solid fa-arrow-right ms-2"></i>
                                </div>
                            </a>
                        </div>
                    </section>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex flex-col p-4 md:p-5 border-t border-gray-200 rounded-b gap-2">
                <div class="italic text-[10px] text-gray-400">
                    <i class="fa-solid fa-circle-info me-2 text-emerald-500"></i>
                    Hanya data yang telah Anda centang di tabel yang akan dicetak.
                </div>
                <div id="unprinted-selected-count-warning-container" class="<?= (($unprintedSelectedCount ?? 0) > 10) ? 'flex' : 'hidden' ?> items-center p-2 text-amber-800 bg-amber-50 rounded-lg border border-amber-100 italic text-[10px] font-bold">
                    <i class="fa-solid fa-triangle-exclamation me-2 text-amber-500"></i>
                    Perhatian: Terdapat <span id="unprinted-selected-count-warning"><?= esc($unprintedSelectedCount) ?></span> data siap cetak. Karena keterbatasan ukuran kertas (Label 121), data akan dicetak dalam beberapa halaman.
                </div>
                <div id="printed-excluded-warning" class="<?= (($selectedCount ?? 0) > ($unprintedSelectedCount ?? 0)) ? 'flex' : 'hidden' ?> items-center p-2 text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-100 italic text-[10px] font-bold">
                    <i class="fa-solid fa-circle-info me-2 text-emerald-500"></i>
                    Catatan: <span id="printed-excluded-count"><?= esc(($selectedCount ?? 0) - ($unprintedSelectedCount ?? 0)) ?></span> data yang sudah dicetak tidak akan diikutkan dalam proses cetak ini.
                </div>
                <div id="no-unprinted-warning" class="<?= (($unprintedSelectedCount ?? 0) === 0 && ($selectedCount ?? 0) > 0) ? 'flex' : 'hidden' ?> items-center p-2 text-red-800 bg-red-50 rounded-lg border border-red-100 italic text-[10px] font-bold">
                    <i class="fa-solid fa-circle-xmark me-2 text-red-500"></i>
                    Peringatan: Tidak ada data baru (belum dicetak) yang dipilih untuk dicetak.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="image-fullscreen-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-all duration-300">
    <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col animate-zoom-in">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 id="preview-modal-title" class="text-sm font-bold text-gray-900 uppercase tracking-widest px-2">Preview</h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-xl text-sm w-10 h-10 inline-flex justify-center items-center transition-colors" data-modal-hide="image-fullscreen-modal">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Image Container -->
        <div class="p-6 md:p-10 bg-gray-50 flex items-center justify-center">
            <img id="fullscreen-preview-img" src="" alt="Preview" class="max-w-full h-auto max-h-[60vh] object-contain rounded-xl shadow-sm border border-gray-200">
        </div>

        <!-- Footer -->
        <div class="p-4 bg-white border-t border-gray-100 text-center">
            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-[0.2em]">LabelPro Visualization Guide</p>
        </div>
    </div>
</div>

<!-- Duplicate Check Modal -->
<div id="duplicate-check-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col max-h-[85vh]">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t shrink-0">
                <h3 class="text-lg font-bold text-gray-900">Hasil Pengecekan Duplikat</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="duplicate-check-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <div class="p-4 md:p-5 overflow-y-auto flex-1">
                <div id="duplicate-loading" class="text-center py-10 hidden">
                    <div class="max-w-xs mx-auto">
                        <div class="mb-4 flex justify-center">
                            <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center animate-pulse">
                                <i class="fa-solid fa-magnifying-glass fa-bounce text-3xl text-emerald-500"></i>
                            </div>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 mb-2">Menganalisis data tamu...</h4>
                        <p class="text-xs text-gray-500">Ini mungkin memakan waktu beberapa saat tergantung jumlah data.</p>
                    </div>
                </div>
                
                <div id="duplicate-list-container" class="space-y-4">
                    <!-- Dynamic content will be injected here -->
                </div>
            </div>
            
            <div class="flex justify-end p-4 md:p-5 border-t border-gray-100 rounded-b shrink-0 bg-gray-50">
                <button type="button" data-modal-hide="duplicate-check-modal" class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all shadow-sm">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>