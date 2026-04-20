<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-6">
    <div class="flex items-center gap-4">
        <div class="bg-emerald-600 p-3 rounded-2xl shadow-lg shadow-emerald-100">
            <i class="fa-solid fa-folder-open text-white text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 leading-none mb-1">Daftar Acara</h1>
            <p class="text-sm text-gray-500 font-medium">
                Kelola acara label Anda untuk pengelompokan yang lebih rapi
            </p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <?php if (session()->get('role') !== 'admin'): ?>
        <button data-modal-target="add-event-modal" data-modal-toggle="add-event-modal" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
            <i class="fa-solid fa-plus me-2"></i>
            Tambah Acara
        </button>
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
    <form action="/events" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <!-- Search -->
        <div class="md:col-span-<?= session()->get('role') === 'admin' ? '3' : '6' ?> relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
            </div>
            <input type="text" name="search" value="<?= esc($search ?? '') ?>" class="block w-full ps-9 text-sm text-gray-900 border border-slate-300 rounded-xl bg-white focus:ring-slate-500 focus:border-slate-500 h-[42px] transition-all placeholder-slate-400" placeholder="Cari nama acara...">
        </div>

        <?php if (session()->get('role') === 'admin'): ?>
        <!-- User Filter -->
        <div class="md:col-span-3">
            <select name="user_id" class="bg-white border border-slate-300 text-gray-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block w-full h-[42px] px-2.5 transition-all">
                <option value="">Semua Pengguna</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['id'] ?>" <?= (string)($userIdFilter ?? '') === (string)$u['id'] ? 'selected' : '' ?>><?= esc($u['username']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>

        <!-- Sort Filter -->
        <div class="md:col-span-3">
            <select name="sort_select" id="sort-select" class="bg-white border border-slate-300 text-gray-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block w-full h-[42px] px-2.5 transition-all" onchange="
                const parts = this.value.split('|');
                document.getElementById('real-sort').value = parts[0];
                document.getElementById('real-dir').value = parts[1];
            ">
                <option value="id|desc" <?= ($sort ?? '') == 'id' ? 'selected' : '' ?>>Urutan: Terbaru</option>
                <option value="name|asc" <?= ($sort ?? '') == 'name' && ($dir ?? 'asc') == 'asc' ? 'selected' : '' ?>>Nama: A-Z</option>
                <option value="name|desc" <?= ($sort ?? '') == 'name' && ($dir ?? 'asc') == 'desc' ? 'selected' : '' ?>>Nama: Z-A</option>
            </select>
            <input type="hidden" name="sort" id="real-sort" value="<?= esc($sort ?? 'id') ?>">
            <input type="hidden" name="dir" id="real-dir" value="<?= esc($dir ?? 'desc') ?>">
        </div>

        <!-- Buttons -->
        <div class="md:col-span-3 flex justify-end gap-2">
            <button type="submit" class="w-full sm:w-32 h-[42px] bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 focus:ring-4 focus:ring-slate-200 transition-all active:scale-95 shadow-md shadow-slate-200 flex items-center justify-center">Filter</button>
            <?php if (!empty($search) || ($sort ?? 'id') !== 'id' || !empty($userIdFilter)): ?>
                <a href="/events" class="w-full sm:w-32 h-[42px] flex items-center justify-center bg-white border border-slate-300 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all active:scale-95 text-center">Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Table -->
<div class="relative overflow-x-auto border border-gray-100 sm:rounded-2xl shadow-sm bg-white">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-bold">Nama Acara</th>
                <?php if (session()->get('role') === 'admin'): ?>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Ditambahkan Oleh</th>
                <?php endif; ?>
                <th scope="col" class="px-6 py-4 font-bold text-center">Dibuat Pada</th>
                <th scope="col" class="px-6 py-4 font-bold text-center">Total Tamu</th>
                <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($events as $event): ?>
                <tr class="bg-white hover:bg-emerald-50/30 transition-colors">
                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-50 p-2 rounded-lg text-emerald-600 flex-shrink-0">
                                <i class="fa-solid fa-folder"></i>
                            </div>
                            <?= esc($event['name']) ?>
                        </div>
                    </th>
                    
                    <?php if (session()->get('role') === 'admin'): ?>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-gray-200">
                                <?= esc($event['added_by'] ?? 'Tidak diketahui') ?>
                            </span>
                        </td>
                    <?php endif; ?>

                    <td class="px-6 py-4 text-center text-gray-400 text-xs">
                        <?= date('d/m/Y', strtotime($event['created_at'])) ?>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-emerald-200">
                            <?= esc($event['total_guests'] ?? 0) ?> Tamu
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 items-center">
                            <?php if (session()->get('role') !== 'admin'): ?>
                            <a href="/guests/import?event_id=<?= $event['id'] ?>" class="p-2 text-gray-400 hover:text-emerald-600 transition-colors" title="Impor Tamu Excel">
                                <i class="fa-solid fa-file-import text-xs"></i>
                            </a>
                            <button type="button" class="p-2 text-gray-400 hover:text-emerald-600 transition-colors edit-event-btn"
                                    data-id="<?= $event['id'] ?>"
                                    data-name="<?= esc($event['name']) ?>"
                                    title="Edit">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <button type="button" data-modal-target="delete-modal-<?= $event['id'] ?>" data-modal-toggle="delete-modal-<?= $event['id'] ?>" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                            <?php endif; ?>
                            <a href="/guests?event_id=<?= $event['id'] ?>" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center px-3 py-1.5 bg-emerald-50 rounded-lg ml-2 border border-emerald-100 transition-colors">
                                Lihat Tamu
                                <i class="fa-solid fa-arrow-right ms-1.5"></i>
                            </a>
                        </div>

                        <!-- Delete Modal -->
                        <div id="delete-modal-<?= $event['id'] ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full text-left">
                                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 text-left">
                                    <div class="p-6 text-center">
                                        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-circle-exclamation text-xl"></i>
                                        </div>
                                        <h3 class="mb-2 text-lg font-bold text-gray-900">Hapus acara ini?</h3>
                                        <p class="mb-1 text-sm text-gray-500 italic">"<?= esc($event['name']) ?>"</p>
                                        <p class="mb-6 text-[10px] text-red-500 font-bold uppercase tracking-widest">Semua tamu dalam acara ini juga akan dihapus!</p>
                                        <div class="flex justify-center gap-3">
                                            <button data-modal-hide="delete-modal-<?= $event['id'] ?>" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                                            <a href="/events/delete/<?= $event['id'] ?>" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-100">Hapus Acara</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($events)): ?>
                <tr>
                    <td colspan="<?= session()->get('role') === 'admin' ? '5' : '4' ?>" class="px-6 py-16 text-center bg-gray-50/30 text-gray-400 font-medium">
                        <div class="max-w-xs mx-auto text-center">
                            <i class="fa-solid fa-folder-open text-4xl mb-4 opacity-20 text-emerald-600"></i>
                            <p class="text-sm font-bold text-gray-900 mb-1">Belum ada acara</p>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <p class="text-xs text-gray-500 leading-relaxed">Sistem belum memiliki acara yang dibuat oleh pengguna.</p>
                            <?php else: ?>
                                <p class="text-xs text-gray-500 leading-relaxed">Mulai dengan membuat acara pertama Anda untuk mengelompokkan tamu label.</p>
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

<!-- Add Event Modal -->
<div id="add-event-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Tambah Acara Baru</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-event-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="/events/store" method="POST" class="p-4 md:p-5 space-y-4 text-left">
                <?= csrf_field() ?>
                <div>
                    <label for="name" class="block mb-2 text-sm font-bold text-gray-900">Nama Acara</label>
                    <input type="text" name="name" id="name" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Contoh: Undangan Pernikahan Budi" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="add-event-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan Acara</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div id="edit-event-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Edit Acara</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-event-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="edit-event-form" action="" method="POST" class="p-4 md:p-5 space-y-4 text-left">
                <?= csrf_field() ?>
                <div>
                    <label for="edit-name" class="block mb-2 text-sm font-bold text-gray-900">Nama Acara</label>
                    <input type="text" name="name" id="edit-name" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="edit-event-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModalElement = document.getElementById('edit-event-modal');
        const editModal = editModalElement ? new Modal(editModalElement) : null;

        document.querySelectorAll('.edit-event-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                const form = document.getElementById('edit-event-form');
                form.querySelector('#edit-name').value = name;
                form.action = '/events/update/' + id;

                if (editModal) editModal.show();
            });
        });
    });
</script>
<?= $this->endSection() ?>
