<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LabelPro - Cetak Label Undangan Otomatis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="flex items-center group">
                    <span class="text-2xl font-extrabold text-gray-900 tracking-tight transition-transform group-hover:scale-105">Label<span class="text-emerald-600">Pro</span></span>
                </a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition-colors">Fitur</a>
                    <a href="#harga" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition-colors">Harga</a>
                    <a href="/demo/start" class="text-sm font-bold text-emerald-600 border-2 border-emerald-600 px-4 py-2 rounded-lg hover:bg-emerald-600 hover:text-white transition-all">Coba Demo</a>
                    <a href="https://wa.me/6282188344982?text=Halo%20LabelPro%2C%20saya%20tertarik%20untuk%20membeli%20akses%20penuh." class="bg-amber-500 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-amber-600 transition-all shadow-lg shadow-amber-200">Beli Sekarang</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center lg:text-left grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight mb-6">
                        Cetak Label Undangan <span class="text-emerald-600">Dalam Hitungan Detik!</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Stop ngetik manual di Word. Impor dari Excel, pilih posisi cetak, dan hasilkan label yang presisi langsung dari browser Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="https://wa.me/6282188344982?text=Halo%20LabelPro%2C%20saya%20ingin%20mendapatkan%20akses%20seumur%20hidup." class="bg-amber-500 text-white px-8 py-4 rounded-xl text-lg font-bold hover:bg-amber-600 transition-all shadow-xl shadow-amber-200 flex items-center justify-center">
                            Akses Penuh
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                        <a href="/demo/start" class="bg-white text-gray-700 border-2 border-gray-200 px-8 py-4 rounded-xl text-lg font-bold hover:border-emerald-600 hover:text-emerald-600 transition-all flex items-center justify-center">
                            Demo Gratis
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-emerald-500/10 rounded-3xl blur-2xl"></div>
                    <img src="/img/hero.svg" alt="Ilustrasi Cetak Label" class="relative w-full mx-auto drop-shadow-2xl transform hover:scale-105 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Problem Section -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-base font-bold text-emerald-600 uppercase tracking-widest mb-4">Masalah Klasik</h2>
                <h3 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6 italic">"Ngetik manual 500 label tamu adalah mimpi buruk bagi siapapun."</h3>
            </div>
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-50">
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-regular fa-clock text-2xl text-red-600"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-4 text-gray-900">Lambat & Manual</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">Mengetik tamu satu per satu sangat membosankan dan menyita waktu produktif Anda berjam-jam.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-50">
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-triangle-exclamation text-2xl text-red-600"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-4 text-gray-900">Boros Kertas</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">Margin meleset atau typo membuat kertas stiker dan tinta terbuang percuma setiap kali gagal.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-50">
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-arrows-up-down-left-right text-2xl text-red-600"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-4 text-gray-900">Layout Berantakan</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">Sulit mengatur posisi teks tetap presisi di tengah label. Hasil cetak seringkali mengecewakan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Solution Section -->
    <section class="py-24" id="fitur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <img src="/img/flow.svg" alt="Workflow LabelPro" class="w-full drop-shadow-2xl transform hover:scale-[1.02] transition-all duration-700">
                </div>
                <div class="order-1 lg:order-2 text-left">
                    <h2 class="text-base font-bold text-emerald-600 uppercase tracking-widest mb-4">Solusi Cerdas</h2>
                    <h3 class="text-4xl font-extrabold mb-8 text-gray-900">Segalanya Serba Otomatis.</h3>
                    <ul class="space-y-10">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mt-1 border border-emerald-100 shadow-sm">
                                <i class="fa-solid fa-bolt text-emerald-600 text-xl"></i>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-lg font-bold text-gray-900">Instant Import</h4>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">Upload Excel, ribuan data siap cetak dalam hitungan detik. Lupakan input manual yang membosankan.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mt-1 border border-emerald-100 shadow-sm">
                                <i class="fa-solid fa-check-double text-emerald-600 text-xl"></i>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-lg font-bold text-gray-900">Database Selection</h4>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">Seleksi tamu tersimpan permanen. Pilih di satu halaman, lanjut di halaman lain tanpa takut pilihan hilang.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mt-1 border border-emerald-100 shadow-sm">
                                <i class="fa-solid fa-expand text-emerald-600 text-xl"></i>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-lg font-bold text-gray-900">Smart Offset</h4>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">Cetak mulai dari label mana saja. Gunakan kembali sisa kertas stiker dengan presisi layout yang sempurna.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-24 bg-emerald-900 text-white" id="harga">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-base font-bold text-emerald-300 uppercase tracking-widest mb-4">Harga</h2>
                <h3 class="text-4xl font-extrabold mb-6">Sekali Bayar, Gunakan Selamanya.</h3>
                <p class="text-emerald-200 text-lg">Tanpa biaya bulanan. Tanpa biaya tersembunyi. Fokus saja pada kesuksesan event Anda.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-center">
                <!-- Paket Basic -->
                <div class="bg-white rounded-3xl overflow-hidden text-gray-900 shadow-xl relative opacity-90 hover:opacity-100 transition-opacity">
                    <div class="p-8 text-center border-b border-gray-100">
                        <h4 class="text-xl font-bold mb-2">Paket Basic</h4>
                        <p class="text-sm text-gray-500 mb-6">Cocok untuk acara kecil</p>
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-extrabold tracking-tight">Rp 49rb</span>
                        </div>
                    </div>
                    <div class="p-8 bg-gray-50">
                        <ul class="text-left space-y-4 mb-8">
                            <li class="flex items-start text-sm">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Maksimal 1 Acara
                            </li>
                            <li class="flex items-start text-sm">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Maksimal 500 Tamu
                            </li>
                            <li class="flex items-start text-sm text-gray-400">
                                <i class="fa-solid fa-xmark text-gray-300 mr-3 mt-0.5"></i>
                                Tidak Ada Update Otomatis
                            </li>
                        </ul>
                        <a href="https://wa.me/6282188344982?text=Halo%20LabelPro%2C%20saya%20ingin%20memesan%20Paket%20Basic." class="block w-full bg-white text-emerald-600 border-2 border-emerald-600 py-3 rounded-xl text-sm font-bold hover:bg-emerald-50 transition-all text-center">
                            Pesan Basic
                        </a>
                    </div>
                </div>

                <!-- Paket Pro -->
                <div class="bg-white rounded-3xl overflow-hidden text-gray-900 shadow-2xl relative transform scale-105 z-10 border-2 border-amber-400">
                    <div class="absolute top-0 inset-x-0 flex justify-center">
                        <span class="bg-amber-500 text-white px-4 py-1 rounded-b-xl text-xs font-bold tracking-wider uppercase shadow-md">
                            Best Seller
                        </span>
                    </div>
                    <div class="p-8 pt-10 text-center border-b border-gray-100">
                        <h4 class="text-2xl font-bold mb-2 text-emerald-600">Paket Pro</h4>
                        <p class="text-sm text-gray-500 mb-6">Pilihan paling populer</p>
                        <div class="flex items-baseline justify-center">
                            <span class="text-5xl font-extrabold tracking-tight">Rp 99rb</span>
                            <span class="ml-2 text-lg text-gray-400 line-through">Rp 150rb</span>
                        </div>
                    </div>
                    <div class="p-8">
                        <ul class="text-left space-y-4 mb-8">
                            <li class="flex items-start text-sm font-medium">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Hingga 10 Acara
                            </li>
                            <li class="flex items-start text-sm font-medium">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Kapasitas 5.000 Tamu
                            </li>
                            <li class="flex items-start text-sm font-medium">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Dukungan Prioritas 24/7
                            </li>
                        </ul>
                        <a href="https://wa.me/6282188344982?text=Halo%20LabelPro%2C%20saya%20ingin%20memesan%20Paket%20Pro." class="block w-full bg-amber-500 text-white py-4 rounded-xl text-lg font-bold hover:bg-amber-600 transition-all shadow-xl shadow-amber-100 text-center">
                            Pesan Paket Pro
                        </a>
                    </div>
                </div>

                <!-- Paket Unlimited -->
                <div class="bg-white rounded-3xl overflow-hidden text-gray-900 shadow-xl relative opacity-90 hover:opacity-100 transition-opacity">
                    <div class="p-8 text-center border-b border-gray-100">
                        <h4 class="text-xl font-bold mb-2">Unlimited</h4>
                        <p class="text-sm text-gray-500 mb-6">Untuk EO & Percetakan</p>
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-extrabold tracking-tight">Rp 199rb</span>
                        </div>
                    </div>
                    <div class="p-8 bg-gray-50">
                        <ul class="text-left space-y-4 mb-8">
                            <li class="flex items-start text-sm">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Acara Tanpa Batas
                            </li>
                            <li class="flex items-start text-sm">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Jumlah Tamu Tak Terbatas
                            </li>
                            <li class="flex items-start text-sm">
                                <i class="fa-solid fa-check text-emerald-500 mr-3 mt-0.5"></i>
                                Gratis Update Selamanya
                            </li>
                        </ul>
                        <a href="https://wa.me/6282188344982?text=Halo%20LabelPro%2C%20saya%20ingin%20memesan%20Paket%20Unlimited." class="block w-full bg-white text-emerald-600 border-2 border-emerald-600 py-3 rounded-xl text-sm font-bold hover:bg-emerald-50 transition-all text-center">
                            Pesan Unlimited
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span class="text-xl font-extrabold text-gray-900 tracking-tight">Label<span class="text-emerald-600">Pro</span></span>
            <p class="mt-4 text-gray-500 text-sm">
                &copy; 2026 LabelPro. Dikembangkan oleh <a href="https://github.com/kalamangna" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors" target="_blank">kalamangna</a>.
            </p>
        </div>
    </footer>

</body>

</html>