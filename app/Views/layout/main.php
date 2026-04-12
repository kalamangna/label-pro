<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'LabelPro' ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50 antialiased">

    <!-- Top Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-200 transition-colors">
                        <span class="sr-only">Buka sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="/dashboard" class="flex ms-2 md:me-24 group">
                        <span class="self-center text-xl font-extrabold sm:text-2xl whitespace-nowrap text-gray-900 tracking-tight transition-transform group-hover:scale-105">Label<span class="text-emerald-600">Pro</span></span>
                    </a>
                </div>
                <div class="flex items-center">
                    <?php if (session()->get('logged_in')): ?>
                        <div class="flex items-center gap-4">
                            <?php if (session()->get('role') === 'demo'): ?>
                                <span class="hidden sm:inline-flex items-center bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-100 shadow-sm">
                                    Mode Demo
                                </span>
                            <?php elseif (session()->get('role') !== 'admin'): ?>
                                <?php 
                                    $userPackage = session()->get('package') ?? 'basic';
                                    $pkgLimits = \App\Models\UserModel::getPackageLimits($userPackage, session()->get('role'));
                                ?>
                                <span class="hidden sm:inline-flex items-center bg-slate-50 text-slate-600 text-xs font-bold px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                                    <i class="fa-solid fa-cube me-1.5 text-slate-400"></i>
                                    <?= esc($pkgLimits['name']) ?>
                                </span>
                            <?php endif; ?>
                            <span class="hidden sm:block text-sm font-semibold text-gray-700"><?= esc(session()->get('username')) ?></span>
                            <a href="/logout" class="text-gray-400 hover:text-red-600 transition-all p-2 rounded-xl hover:bg-red-50" title="Keluar">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-100 sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium text-sm">
                <li>
                    <a href="/dashboard" class="flex items-center p-3 rounded-2xl transition-all <?= current_url() == base_url('dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' ?> group">
                        <i class="fa-solid fa-house w-5 h-5 flex items-center justify-center transition duration-75 <?= current_url() == base_url('dashboard') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-emerald-600' ?>"></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/projects" class="flex items-center p-3 rounded-2xl transition-all <?= str_starts_with(current_url(), base_url('projects')) ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' ?> group">
                        <i class="fa-solid fa-folder-open w-5 h-5 flex items-center justify-center transition duration-75 <?= str_starts_with(current_url(), base_url('projects')) ? 'text-emerald-600' : 'text-gray-400 group-hover:text-emerald-600' ?>"></i>
                        <span class="ms-3 whitespace-nowrap">Proyek</span>
                    </a>
                </li>
                <li>
                    <a href="/recipients" class="flex items-center p-3 rounded-2xl transition-all <?= str_starts_with(current_url(), base_url('recipients')) && current_url() != base_url('recipients/import') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' ?> group">
                        <i class="fa-solid fa-users w-5 h-5 flex items-center justify-center transition duration-75 <?= str_starts_with(current_url(), base_url('recipients')) && current_url() != base_url('recipients/import') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-emerald-600' ?>"></i>
                        <span class="ms-3 whitespace-nowrap">Penerima</span>
                    </a>
                </li>
                <?php if (session()->get('role') === 'admin'): ?>
                    <li>
                        <a href="/users" class="flex items-center p-3 rounded-2xl transition-all <?= str_starts_with(current_url(), base_url('users')) ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' ?> group">
                            <i class="fa-solid fa-user-gear w-5 h-5 flex items-center justify-center transition duration-75 <?= str_starts_with(current_url(), base_url('users')) ? 'text-emerald-600' : 'text-gray-400 group-hover:text-emerald-600' ?>"></i>
                            <span class="ms-3 whitespace-nowrap">Pengguna</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 min-h-[calc(100vh-14rem)] shadow-sm">
                <?= $this->renderSection('content') ?>
            </div>

            <footer class="mt-8 py-12 bg-gray-50 border-t border-gray-200">
                <div class="text-center">
                    <span class="text-xl font-extrabold text-gray-900 tracking-tight">Label<span class="text-emerald-600">Pro</span></span>
                    <p class="mt-4 text-gray-500 text-sm">
                        &copy; 2026 LabelPro. Dikembangkan oleh <a href="https://github.com/kalamangna" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors" target="_blank">kalamangna</a>.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>