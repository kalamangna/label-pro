<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LabelPro</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-gray-100">
        <div>
            <h2 class="text-center text-3xl font-extrabold tracking-tight text-gray-900">
                Label<span class="text-emerald-600">Pro</span>
            </h2>
            <p class="mt-2 text-center text-sm font-medium text-gray-500">
                Silakan masuk ke akun Anda
            </p>
        </div>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="flex items-center p-4 text-red-800 rounded-2xl bg-red-50 border border-red-100 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation text-lg"></i>
                <div class="ms-3 text-sm font-bold">
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="flex items-start p-4 text-red-800 rounded-2xl bg-red-50 border border-red-100 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation text-lg mt-0.5"></i>
                <ul class="ms-3 text-sm font-bold list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="/login" method="POST">
            <?= csrf_field() ?>
            <div class="space-y-5">
                <div>
                    <label for="username" class="block mb-2 text-sm font-bold text-gray-900">Username</label>
                    <input id="username" name="username" type="text" required class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 transition-all" placeholder="Masukkan username Anda..." value="<?= old('username') ?>">
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-bold text-gray-900">Password</label>
                    <input id="password" name="password" type="password" required class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 transition-all" placeholder="••••••••">
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 transition-all active:scale-95 shadow-lg shadow-emerald-100">
                    Masuk ke LabelPro
                </button>
            </div>
        </form>
        
        <div class="text-center mt-6">
            <a href="/" class="text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors inline-flex items-center">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
