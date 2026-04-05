<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
  <!-- Total Recipients Card -->
  <div class="bg-white overflow-hidden shadow rounded-lg transition-transform hover:scale-[1.02]">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-emerald-500 rounded-md p-3">
          <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 15.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Penerima</dt>
            <dd class="flex items-baseline">
              <div class="text-2xl font-semibold text-gray-900"><?= $totalRecipients ?></div>
            </dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="bg-gray-50 px-5 py-3">
      <div class="text-sm">
        <a href="/recipients" class="font-medium text-emerald-700 hover:text-emerald-900">Lihat semua daftar</a>
      </div>
    </div>
  </div>

  <!-- Label Templates -->
  <div class="bg-white overflow-hidden shadow rounded-lg transition-transform hover:scale-[1.02]">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
          <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Template Tersedia</dt>
            <dd class="flex items-baseline">
              <div class="text-2xl font-semibold text-gray-900">103 & 121</div>
            </dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="bg-gray-50 px-5 py-3">
      <div class="text-sm">
        <span class="font-medium text-green-700">Kompatibel Kertas A4</span>
      </div>
    </div>
  </div>

  <!-- Quick Import -->
  <div class="bg-white overflow-hidden shadow rounded-lg transition-transform hover:scale-[1.02]">
    <div class="p-5">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
          <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
          </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">Alat Impor</dt>
            <dd class="flex items-baseline">
              <div class="text-lg font-semibold text-gray-900">Excel (.xlsx)</div>
            </dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="bg-gray-50 px-5 py-3">
      <div class="text-sm">
        <a href="/recipients/import" class="font-medium text-blue-700 hover:text-blue-900">Mulai impor sekarang</a>
      </div>
    </div>
  </div>
</div>

<div class="mt-8">
    <div class="bg-emerald-700 rounded-lg shadow-xl overflow-hidden">
        <div class="px-6 py-12 md:px-12 text-center md:text-left md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Siap untuk cetak label Anda?
                </h2>
                <p class="mt-3 text-lg text-emerald-100">
                    Kelola daftar tamu Anda dan hasilkan label undangan profesional dalam hitungan detik.
                </p>
            </div>
            <div class="mt-8 flex flex-col sm:flex-row justify-center md:mt-0 md:ml-8 space-y-3 sm:space-y-0 sm:space-x-3">
                <a href="/recipients/create" class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-emerald-700 bg-white hover:bg-emerald-50 transition-colors">
                    Tambah Penerima
                </a>
                <a href="/recipients" class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-amber-500 hover:bg-amber-400 transition-colors">
                    Cetak Label
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
