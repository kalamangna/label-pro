<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-6">
    <div class="flex items-center gap-4">
        <div class="bg-amber-500 p-3 rounded-2xl shadow-lg shadow-amber-100">
            <i class="fa-solid fa-book-open text-white text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 leading-none mb-1">Panduan Penggunaan</h1>
            <p class="text-sm text-gray-500 font-medium">
                Pelajari cara menggunakan LabelPro untuk hasil cetak yang maksimal
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-12">
        <!-- Alur Kerja -->
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-black text-sm">1</span>
                <h2 class="text-lg font-bold text-gray-900">Alur Kerja Cepat (Quick Start)</h2>
            </div>
            
            <div class="relative border-l-2 border-emerald-100 ms-4 ps-8 space-y-10">
                <!-- Step 1 -->
                <div class="relative">
                    <span class="absolute -left-[41px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500 text-white text-[10px]">
                        <i class="fa-solid fa-check"></i>
                    </span>
                    <h3 class="font-bold text-gray-900 mb-2">Buat Acara Baru</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">
                        Setiap data tamu dikelompokkan dalam "Acara". Pergi ke menu <span class="font-bold text-emerald-600">Acara</span> dan buatlah satu (contoh: Undangan Pernikahan Budi).
                    </p>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 inline-flex items-center gap-3">
                        <i class="fa-solid fa-folder-plus text-emerald-600"></i>
                        <span class="text-xs font-bold text-gray-600">Menu Acara > Tambah Acara</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <span class="absolute -left-[41px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500 text-white text-[10px]">
                        <i class="fa-solid fa-check"></i>
                    </span>
                    <h3 class="font-bold text-gray-900 mb-2">Isi Daftar Tamu</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">
                        Anda bisa menambah tamu satu per satu atau menggunakan <span class="font-bold text-emerald-600">Impor Excel</span> untuk jumlah yang banyak. Pastikan format file sesuai dengan template yang disediakan.
                    </p>
                    <a href="/template_impor_tamu_labelpro.xlsx" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-emerald-600 hover:bg-emerald-50 transition-all shadow-sm">
                        <i class="fa-solid fa-download me-2"></i>
                        Unduh Template Excel
                    </a>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <span class="absolute -left-[41px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500 text-white text-[10px]">
                        <i class="fa-solid fa-check"></i>
                    </span>
                    <h3 class="font-bold text-gray-900 mb-2">Pilih & Cetak Label</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">
                        Masuk ke daftar tamu acara tersebut, <span class="font-bold text-emerald-600">centang nama</span> yang ingin dicetak, lalu klik tombol <span class="font-bold text-amber-500">Cetak Label</span> di toolbar bawah.
                    </p>
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-center gap-3">
                        <i class="fa-solid fa-print text-amber-500"></i>
                        <span class="text-xs font-bold text-amber-800">Cetak otomatis per 10 tamu sesuai ukuran stiker</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-black text-sm">2</span>
                <h2 class="text-lg font-bold text-gray-900">Pertanyaan Sering Diajukan (FAQ)</h2>
            </div>

            <div id="accordion-faq" data-accordion="collapse" data-active-classes="bg-emerald-50 text-emerald-700" data-inactive-classes="text-gray-500">
                <h2 id="accordion-faq-heading-1">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-bold text-left border border-b-0 border-gray-200 rounded-t-2xl focus:ring-4 focus:ring-emerald-100 hover:bg-emerald-50 transition-all gap-3" data-accordion-target="#accordion-faq-body-1" aria-expanded="true" aria-controls="accordion-faq-body-1">
                        <span>Apa itu fitur "Mulai dari posisi ke-" saat mencetak?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-faq-body-1" class="hidden" aria-labelledby="accordion-faq-heading-1">
                    <div class="p-5 border border-b-0 border-gray-200">
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Fitur ini berguna jika Anda memiliki kertas stiker Label 121 yang sudah pernah dipakai sebagian. Misalnya, jika 3 stiker pertama sudah kosong, Anda bisa memilih <span class="font-bold text-emerald-600">Mulai dari posisi ke-4</span> agar printer mulai mencetak di stiker yang masih tersedia.
                        </p>
                    </div>
                </div>

                <h2 id="accordion-faq-heading-2">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-bold text-left border border-b-0 border-gray-200 focus:ring-4 focus:ring-emerald-100 hover:bg-emerald-50 transition-all gap-3" data-accordion-target="#accordion-faq-body-2" aria-expanded="false" aria-controls="accordion-faq-body-2">
                        <span>Kenapa hasil cetakan tidak pas di tengah stiker?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-faq-body-2" class="hidden" aria-labelledby="accordion-faq-heading-2">
                    <div class="p-5 border border-b-0 border-gray-200">
                        <p class="text-sm text-gray-500 leading-relaxed mb-3">
                            Ada dua hal yang perlu diperiksa:
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2 list-disc ps-5">
                            <li>Pastikan saat print, <span class="font-bold text-gray-700">Scale</span> diatur ke <span class="font-bold text-emerald-600">Default</span> atau <span class="font-bold text-emerald-600">100%</span> (Jangan "Fit to page").</li>
                            <li>Gunakan fitur <span class="font-bold text-gray-700">Perataan Horizontal</span> (Kiri/Tengah/Kanan) sebelum mencetak untuk menyesuaikan dengan posisi masuk kertas di printer Anda.</li>
                        </ul>
                    </div>
                </div>

                <h2 id="accordion-faq-heading-3">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-bold text-left border border-gray-200 rounded-b-2xl focus:ring-4 focus:ring-emerald-100 hover:bg-emerald-50 transition-all gap-3" data-accordion-target="#accordion-faq-body-3" aria-expanded="false" aria-controls="accordion-faq-body-3">
                        <span>Dapatkah saya mencetak ulang tamu yang sudah ditandai?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-faq-body-3" class="hidden" aria-labelledby="accordion-faq-heading-3">
                    <div class="p-5 border border-t-0 border-gray-200 rounded-b-2xl">
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Bisa. Anda cukup mengedit data tamu tersebut melalui tombol <i class="fa-solid fa-pen-to-square text-emerald-600"></i> Edit, lalu ubah statusnya kembali menjadi <span class="font-bold text-emerald-600">Belum Dicetak</span>.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <div class="p-6 bg-emerald-600 rounded-3xl text-white shadow-xl shadow-emerald-100 relative overflow-hidden">
            <i class="fa-solid fa-lightbulb absolute -right-4 -bottom-4 text-8xl opacity-10"></i>
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i>
                Tips & Trik
            </h3>
            <ul class="space-y-4 text-sm font-medium">
                <li class="flex gap-3">
                    <i class="fa-solid fa-check-circle mt-1 opacity-60"></i>
                    <span>Gunakan browser <span class="font-black">Google Chrome</span> untuk hasil pratinjau cetak terbaik.</span>
                </li>
                <li class="flex gap-3">
                    <i class="fa-solid fa-check-circle mt-1 opacity-60"></i>
                    <span>Nama tamu akan otomatis dicetak dengan huruf besar/kecil sesuai input Anda.</span>
                </li>
                <li class="flex gap-3">
                    <i class="fa-solid fa-check-circle mt-1 opacity-60"></i>
                    <span>Jika alamat kosong, sistem akan mencetak <span class="italic font-bold">"Tempat"</span> secara otomatis.</span>
                </li>
            </ul>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-3xl">
            <h3 class="text-gray-900 font-bold mb-4 flex items-center gap-2 text-sm uppercase tracking-widest">
                <i class="fa-solid fa-ruler-combined text-emerald-600"></i>
                Spesifikasi Label
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Tipe</span>
                    <span class="font-bold text-gray-900">Label 121</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Ukuran</span>
                    <span class="font-bold text-gray-900">38 x 75 mm</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Tata Letak</span>
                    <span class="font-bold text-gray-900">2 Kolom x 5 Baris</span>
                </div>
                <div class="flex justify-between items-center text-sm pt-2 border-t border-gray-50">
                    <span class="text-gray-500">Total / Lembar</span>
                    <span class="font-black text-emerald-600">10 Stiker</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>