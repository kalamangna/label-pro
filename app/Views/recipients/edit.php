<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Edit Penerima</h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="/recipients" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
        <div class="px-4 py-5 sm:p-6">
            <form action="/recipients/update/<?= $recipient['id'] ?>" method="POST">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 gap-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="<?= old('name', $recipient['name']) ?>" class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="Nama Lengkap">
                        </div>
                        <?php if (isset(session('errors')['name'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= session('errors')['name'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <div class="mt-1">
                            <textarea id="address" name="address" rows="3" class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="Alamat lengkap..."><?= old('address', $recipient['address']) ?></textarea>
                        </div>
                        <?php if (isset(session('errors')['address'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= session('errors')['address'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            Update Penerima
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
