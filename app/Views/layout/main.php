<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'LabelPro' ?></title>
    
    <?php if (ENVIRONMENT === 'development'): ?>
        <script type="module" src="http://localhost:5173/@vite/client"></script>
        <link rel="stylesheet" href="http://localhost:5173/resources/css/app.css">
    <?php else: ?>
        <?php
            $manifestPath = FCPATH . 'build/.vite/manifest.json';
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                $cssFile = $manifest['resources/css/app.css']['file'] ?? '';
                if ($cssFile) {
                    echo '<link rel="stylesheet" href="/build/' . $cssFile . '">';
                }
            }
        ?>
    <?php endif; ?>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full overflow-hidden flex bg-gray-100" x-data="{ sidebarOpen: false }">

    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>

        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex-1 flex flex-col max-w-xs w-full bg-emerald-700">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="sidebarOpen = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Tutup sidebar</span>
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <div class="flex-shrink-0 flex items-center px-4">
                    <span class="text-white text-2xl font-bold tracking-wider">LabelPro</span>
                </div>
                <nav class="mt-5 px-2 space-y-1">
                    <a href="/" class="bg-emerald-800 text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <svg class="mr-4 flex-shrink-0 h-6 w-6 text-emerald-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Beranda
                    </a>
                    <a href="/recipients" class="text-emerald-100 hover:bg-emerald-600 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <svg class="mr-4 flex-shrink-0 h-6 w-6 text-emerald-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 15.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Data Penerima
                    </a>
                    <a href="/recipients/import" class="text-emerald-100 hover:bg-emerald-600 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <svg class="mr-4 flex-shrink-0 h-6 w-6 text-emerald-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Impor Excel
                    </a>
                </nav>
            </div>
        </div>

        <div class="flex-shrink-0 w-14" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
        <div class="flex flex-col flex-grow pt-5 bg-emerald-700 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <span class="text-white text-2xl font-bold tracking-wider">LabelPro</span>
            </div>
            <div class="mt-8 flex-1 flex flex-col">
                <nav class="flex-1 px-2 pb-4 space-y-1">
                    <a href="/dashboard" class="<?= url_is('dashboard') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors">
                        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-emerald-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Beranda
                    </a>
                    <a href="/recipients" class="<?= url_is('recipients*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors">
                        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-emerald-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 15.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Data Penerima
                    </a>
                    <a href="/recipients/import" class="<?= url_is('recipients/import') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors">
                        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-emerald-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Impor Excel
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <div class="md:pl-64 flex flex-col flex-1 w-0">
        <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <button @click="sidebarOpen = true" type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500 md:hidden">
                <span class="sr-only">Buka sidebar</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900"><?= $title ?? 'Beranda' ?></h1>
                </div>
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- User Menu / Notifications (Optional) -->
                </div>
            </div>
        </div>

        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
