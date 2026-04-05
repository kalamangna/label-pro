<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="sm:flex sm:items-center sm:justify-between">
  <div>
    <h1 class="text-2xl font-bold text-gray-900">Daftar Penerima</h1>
    <p class="mt-2 text-sm text-gray-700">Kelola daftar tamu undangan dan alur cetak Anda di sini.</p>
  </div>
  <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex flex-wrap gap-2">
    <div class="relative inline-block text-left" x-data="{ open: false }">
      <button @click="open = !open" @click.away="open = false" type="button" class="inline-flex items-center justify-center px-4 py-2 border border-amber-500 shadow-sm text-sm font-medium rounded-md text-amber-600 bg-white hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Cetak Label Terpilih
        <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
      <div x-show="open" 
           x-transition:enter="transition ease-out duration-100"
           x-transition:enter-start="transform opacity-0 scale-95"
           x-transition:enter-end="transform opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-75"
           x-transition:leave-start="transform opacity-100 scale-100"
           x-transition:leave-end="transform opacity-0 scale-95"
           class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none;">
        <div class="py-1" role="menu" aria-orientation="vertical">
          <a href="/recipients/print?type=103" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700" role="menuitem">Label 103 (32x64)</a>
          <a href="/recipients/print?type=121" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700" role="menuitem">Label 121 (38x75)</a>
        </div>
      </div>
    </div>
    
    <a href="/recipients/import" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
      <svg class="mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
      </svg>
      Impor
    </a>
    
    <a href="/recipients/create" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
      <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Penerima
    </a>
  </div>
</div>

<?php if (session()->getFlashdata('message')): ?>
<div class="rounded-md bg-green-50 p-4 mt-6 border border-green-200">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
    </div>
    <div class="ml-3">
      <p class="text-sm font-medium text-green-800"><?= session()->getFlashdata('message') ?></p>
    </div>
  </div>
</div>
<?php endif; ?>

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

<div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
  <form action="/recipients" method="GET" class="w-full flex flex-col sm:flex-row gap-4 items-center">
    <div class="w-full sm:w-auto flex-1">
      <label for="search" class="sr-only">Cari</label>
      <div class="relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
          </svg>
        </div>
        <input type="text" name="search" id="search" value="<?= esc($search ?? '') ?>" class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border" placeholder="Cari nama atau alamat...">
      </div>
    </div>
    
    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
      <select name="status" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
        <option value="">Semua Status</option>
        <option value="0" <?= ($status ?? '') === '0' ? 'selected' : '' ?>>Belum Dicetak</option>
        <option value="1" <?= ($status ?? '') === '1' ? 'selected' : '' ?>>Sudah Dicetak</option>
      </select>

      <select name="sort" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
        <option value="id" <?= ($sort ?? '') == 'id' ? 'selected' : '' ?>>Urutan: Default</option>
        <option value="name" <?= ($sort ?? '') == 'name' ? 'selected' : '' ?>>Urutan: Nama</option>
        <option value="address" <?= ($sort ?? '') == 'address' ? 'selected' : '' ?>>Urutan: Alamat</option>
        <option value="created_at" <?= ($sort ?? '') == 'created_at' ? 'selected' : '' ?>>Urutan: Tanggal</option>
      </select>

      <select name="dir" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
        <option value="asc" <?= ($dir ?? '') == 'asc' ? 'selected' : '' ?>>A-Z / Lama</option>
        <option value="desc" <?= ($dir ?? '') == 'desc' ? 'selected' : '' ?>>Z-A / Baru</option>
      </select>

      <button type="submit" class="w-full sm:w-auto inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
        Terapkan
      </button>
      
      <?php if(!empty($search) || ($status ?? '') !== '' || ($sort ?? 'id') != 'id' || ($dir ?? 'desc') != 'desc'): ?>
      <a href="/recipients" class="w-full sm:w-auto inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
        Reset
      </a>
      <?php endif; ?>
    </div>
  </form>
</div>

<div class="mt-4 flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                <input type="checkbox" id="select-all" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded cursor-pointer">
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32 text-center">Sudah Dicetak</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
              <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($recipients as $recipient): ?>
            <tr id="row-<?= $recipient['id'] ?>" class="hover:bg-gray-50 transition-colors <?= ($recipient['is_printed'] ?? 0) ? 'bg-gray-50 opacity-60' : '' ?>">
              <td class="px-6 py-4 whitespace-nowrap">
                <input type="checkbox" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded cursor-pointer toggle-select" data-id="<?= $recipient['id'] ?>" <?= ($recipient['is_selected'] ?? 0) ? 'checked' : '' ?>>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <input type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded cursor-pointer toggle-printed" data-id="<?= $recipient['id'] ?>" <?= ($recipient['is_printed'] ?? 0) ? 'checked' : '' ?>>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 <?= ($recipient['is_printed'] ?? 0) ? 'line-through' : '' ?>"><?= esc($recipient['name']) ?></div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-500 line-clamp-1 <?= ($recipient['is_printed'] ?? 0) ? 'line-through' : '' ?>"><?= esc($recipient['address']) ?></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                <a href="/recipients/edit/<?= $recipient['id'] ?>" class="text-emerald-600 hover:text-emerald-900">Ubah</a>
                <a href="/recipients/delete/<?= $recipient['id'] ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus penerima ini?')">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($recipients)): ?>
            <tr>
              <td colspan="5" class="px-6 py-10 text-sm text-gray-500 text-center bg-gray-50">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="mt-2 font-medium">Data penerima tidak ditemukan</p>
                <p class="mt-1">Mulai dengan menambah penerima baru atau impor dari Excel.</p>
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="mt-4">
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
                alert('Maksimal 10 penerima yang dapat dipilih untuk dicetak sekaligus.');
                this.checked = false;
                return;
            }

            const id = this.getAttribute('data-id');
            const originalState = !this.checked;
            
            fetch(`/recipients/select/${id}`, {
                method: 'POST',
                headers: headers,
            }).then(response => response.json()).then(data => {
                if (!data.success) {
                    alert('Gagal memperbarui status pilihan.');
                    this.checked = originalState;
                }
                updateSelectAllState();
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
            
            if (isChecked && ids.length > 10) {
                alert('Hanya 10 data pertama di halaman ini yang akan dipilih (Limit Cetak).');
            }

            const targetIds = isChecked ? ids.slice(0, 10) : ids;
            
            fetch(`/recipients/bulk-select`, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({ ids: targetIds, state: isChecked ? 1 : 0 })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    selectCheckboxes.forEach((cb, index) => {
                        if (isChecked) {
                            cb.checked = index < 10;
                        } else {
                            cb.checked = false;
                        }
                    });
                } else {
                    alert('Gagal memperbarui pilihan massal.');
                    this.checked = !isChecked;
                }
                updateSelectAllState();
            }).catch(() => {
                alert('Terjadi kesalahan jaringan.');
                this.checked = !isChecked;
                updateSelectAllState();
            });
        });
    }

    updateSelectAllState();

    document.querySelectorAll('.toggle-printed').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const originalState = !this.checked;
            const row = document.getElementById(`row-${id}`);
            const textElements = row.querySelectorAll('.text-sm');
            
            fetch(`/recipients/printed/${id}`, {
                method: 'POST',
                headers: headers,
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    if (data.is_printed == 1) {
                        row.classList.add('bg-gray-50', 'opacity-60');
                        textElements.forEach(el => el.classList.add('line-through'));
                    } else {
                        row.classList.remove('bg-gray-50', 'opacity-60');
                        textElements.forEach(el => el.classList.remove('line-through'));
                    }
                } else {
                    alert('Gagal memperbarui status cetak.');
                    this.checked = originalState;
                }
            }).catch(() => {
                alert('Terjadi kesalahan jaringan.');
                this.checked = originalState;
            });
        });
    });
});
</script>
<?= $this->endSection() ?>
