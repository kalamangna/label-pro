<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-6">
    <div class="flex items-center gap-4">
        <div class="bg-slate-800 p-3 rounded-2xl shadow-lg shadow-slate-100">
            <i class="fa-solid fa-user-gear text-white text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 leading-none mb-1">Kelola Pengguna</h1>
            <p class="text-sm text-gray-500 font-medium">
                Daftar akun yang memiliki akses ke sistem LabelPro
            </p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button data-modal-target="add-user-modal" data-modal-toggle="add-user-modal" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100 active:scale-95">
            <i class="fa-solid fa-user-plus me-2"></i>
            Tambah Pengguna
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

<!-- Table -->
<div class="relative overflow-x-auto border border-gray-100 sm:rounded-2xl shadow-sm bg-white">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-bold">Username</th>
                <th scope="col" class="px-6 py-4 font-bold text-center">Peran (Role)</th>
                <th scope="col" class="px-6 py-4 font-bold text-center">Dibuat Pada</th>
                <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($users as $user): ?>
                <tr class="bg-white hover:bg-slate-50/50 transition-colors">
                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase">
                                <?= substr($user['username'], 0, 2) ?>
                            </div>
                            <?= esc($user['username']) ?>
                            <?php if($user['id'] == session()->get('user_id')): ?>
                                <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full border border-blue-100">Saya</span>
                            <?php endif; ?>
                        </div>
                    </th>
                    <td class="px-6 py-4 text-center">
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="bg-purple-50 text-purple-700 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-purple-100 uppercase tracking-wider">Administrator</span>
                        <?php elseif ($user['role'] === 'demo'): ?>
                            <span class="bg-amber-50 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-amber-100 uppercase tracking-wider">Demo User</span>
                        <?php else: ?>
                            <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100 uppercase tracking-wider">Standard User</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center text-gray-400 text-xs">
                        <?= date('d M Y, H:i', strtotime($user['created_at'])) ?> WIB
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button type="button" class="p-2 text-gray-400 hover:text-emerald-600 transition-colors edit-user-btn" 
                                    data-id="<?= $user['id'] ?>" 
                                    data-username="<?= esc($user['username']) ?>" 
                                    data-role="<?= esc($user['role']) ?>"
                                    title="Edit">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <?php if($user['id'] != session()->get('user_id')): ?>
                                <button type="button" data-modal-target="delete-modal-<?= $user['id'] ?>" data-modal-toggle="delete-modal-<?= $user['id'] ?>" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Delete Modal -->
                        <div id="delete-modal-<?= $user['id'] ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full text-left">
                                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
                                    <div class="p-6 text-center">
                                        <div class="w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                                        </div>
                                        <h3 class="mb-2 text-lg font-bold text-gray-900">Hapus pengguna ini?</h3>
                                        <p class="mb-6 text-sm text-gray-500 italic">"<?= esc($user['username']) ?>"</p>
                                        <div class="flex justify-center gap-3">
                                            <button data-modal-hide="delete-modal-<?= $user['id'] ?>" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                                            <a href="/users/delete/<?= $user['id'] ?>" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-100">Ya, Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div id="add-user-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Tambah Pengguna Baru</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-user-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="/users/store" method="POST" class="p-4 md:p-5 space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="username" class="block mb-2 text-sm font-bold text-gray-900">Username</label>
                    <input type="text" name="username" id="username" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="Contoh: admin_label" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-bold text-gray-900">Password</label>
                    <input type="password" name="password" id="password" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="••••••••" required>
                </div>
                <div>
                    <label for="role" class="block mb-2 text-sm font-bold text-gray-900">Peran (Role)</label>
                    <select name="role" id="role" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                        <option value="user">Standard User</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="add-user-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="edit-user-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-bold text-gray-900">Edit Pengguna</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-user-modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="edit-user-form" action="" method="POST" class="p-4 md:p-5 space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="edit-username" class="block mb-2 text-sm font-bold text-gray-900">Username</label>
                    <input type="text" name="username" id="edit-username" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" required>
                </div>
                <div>
                    <label for="edit-password" class="block mb-2 text-sm font-bold text-gray-900">Password Baru <span class="text-[10px] font-normal text-gray-400 italic">(Kosongkan jika tidak ingin diubah)</span></label>
                    <input type="password" name="password" id="edit-password" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" placeholder="••••••••">
                </div>
                <div>
                    <label for="edit-role" class="block mb-2 text-sm font-bold text-gray-900">Peran (Role)</label>
                    <select name="role" id="edit-role" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                        <option value="user">Standard User</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="edit-user-modal" class="px-4 py-2 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit User Modal Logic
        const editUserModalElement = document.getElementById('edit-user-modal');
        const editUserModal = editUserModalElement ? new Modal(editUserModalElement) : null;
        
        document.querySelectorAll('.edit-user-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');
                const role = this.getAttribute('data-role');
                
                const modal = document.getElementById('edit-user-modal');
                modal.querySelector('#edit-username').value = username;
                modal.querySelector('#edit-role').value = role;
                modal.querySelector('#edit-password').value = '';
                modal.querySelector('#edit-user-form').action = '/users/update/' + id;
                
                if (editUserModal) editUserModal.show();
            });
        });
    });
</script>
<?= $this->endSection() ?>
