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
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-700 mb-6">
                        🚀 Versi 2.0 Telah Rilis!
                    </span>
                    <h1 class="text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight mb-6">
                        Cetak Label Undangan <span class="text-emerald-600">Dalam Hitungan Detik!</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Stop ngetik manual di Word. Impor dari Excel, pilih ukuran label, dan cetak label yang presisi secara instan.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="https://wa.me/6282188344982?text=Halo%20LabelPro%2C%20saya%20ingin%20mendapatkan%20akses%20seumur%20hidup." class="bg-amber-500 text-white px-8 py-4 rounded-xl text-lg font-bold hover:bg-amber-600 transition-all shadow-xl shadow-amber-200 flex items-center justify-center">
                            Akses Penuh
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        <a href="/demo/start" class="bg-white text-gray-700 border-2 border-gray-200 px-8 py-4 rounded-xl text-lg font-bold hover:border-emerald-600 hover:text-emerald-600 transition-all flex items-center justify-center">
                            Demo Gratis
                        </a>
                    </div>
                    <div class="mt-10 flex items-center justify-center lg:justify-start space-x-4 text-sm text-gray-500">
                        <div class="flex -space-x-2">
                            <img class="w-8 h-8 rounded-full border-2 border-white bg-gray-200" src="https://i.pravatar.cc/100?u=1" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white bg-gray-200" src="https://i.pravatar.cc/100?u=2" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white bg-gray-200" src="https://i.pravatar.cc/100?u=3" alt="">
                        </div>
                        <p>Dipercaya oleh 500+ Wedding Organizer & Percetakan</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-emerald-500/10 rounded-3xl blur-2xl"></div>
                    <img src="/img/undraw_printing.svg" alt="Ilustrasi Cetak Label" class="relative w-full max-w-lg mx-auto drop-shadow-2xl transform hover:scale-105 transition-transform duration-500">
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
                <div class="p-8 bg-white rounded-2xl shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Buang Waktu</h4>
                    <p class="text-gray-600">Berjam-jam ngetik satu per satu di Word yang seringkali layout-nya berantakan saat diprint.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Typo & Salah Nama</h4>
                    <p class="text-gray-600">Satu kesalahan kecil berarti Anda harus print ulang satu lembar. Kertas stiker dan tinta terbuang percuma.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Margin Gak Pas</h4>
                    <p class="text-gray-600">Stres ngatur margin di software office konvensional demi mendapatkan posisi tengah yang presisi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Solution Section -->
    <section class="py-24" id="fitur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <img src="/img/undraw_spreadsheet.svg" alt="Manajemen Data Tamu" class="w-full max-w-md mx-auto drop-shadow-xl">
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="text-base font-bold text-emerald-600 uppercase tracking-widest mb-4">Solusi Cerdas</h2>
                    <h3 class="text-4xl font-extrabold mb-8">Cara Profesional Mengelola Daftar Tamu.</h3>
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold">Impor Dari Excel</h4>
                                <p class="text-gray-600 text-sm mt-1">Cukup drag and drop daftar tamu Anda. Biarkan sistem kami yang bekerja.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold">Siap Pakai Untuk Label 121</h4>
                                <p class="text-gray-600 text-sm mt-1">Template presisi untuk ukuran stiker label paling populer di Indonesia.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold">Export Ke PDF & Cetak Langsung</h4>
                                <p class="text-gray-600 text-sm mt-1">Export hasil ke PDF berkualitas tinggi atau cetak langsung dari browser Anda.</p>
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

            <div class="max-w-md mx-auto bg-white rounded-3xl overflow-hidden text-gray-900 shadow-2xl relative">
                <div class="absolute top-0 right-0 bg-amber-500 text-white px-6 py-2 rounded-bl-3xl text-sm font-bold">
                    BEST SELLER
                </div>
                <div class="p-10 text-center">
                    <h4 class="text-2xl font-bold mb-4">Akses Unlimited</h4>
                    <div class="flex items-baseline justify-center mb-8">
                        <span class="text-5xl font-extrabold tracking-tight">Rp 99rb</span>
                        <span class="ml-1 text-xl text-gray-500 line-through">Rp 250rb</span>
                    </div>
                    <ul class="text-left space-y-4 mb-10">
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                            </svg>
                            Jumlah Tamu Tak Terbatas
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                            </svg>
                            Akses Template Label 121
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                            </svg>
                            Gratis Update Selamanya
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                            </svg>
                            Dukungan Prioritas
                        </li>
                    </ul>
                    <a href="https://wa.me/6282188344982?text=Halo%20LabelPro%2C%20saya%20ingin%20memesan%20paket%20Akses%20Unlimited." class="block bg-amber-500 text-white py-4 rounded-xl text-lg font-bold hover:bg-amber-600 transition-all shadow-xl shadow-amber-100">
                        Pesan Sekarang
                    </a>
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

</html>>l>>