<?= $this->extend('siswa/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto mt-8 p-8 bg-white rounded-2xl shadow-lg flex flex-col md:flex-row gap-8">
    <div class="flex flex-col items-center w-full md:w-1/3 gap-3">
        <img src="<?= base_url('uploads/user/' . (($user['foto'] ?? null) ? $user['foto'] : 'default.png')) ?>"
             class="rounded-full h-32 w-32 object-cover shadow-md border-4 border-blue-200" alt="Profile Picture">

        <form action="<?= base_url('siswa/profile/update') ?>" method="post" enctype="multipart/form-data" class="w-full mt-4">
            <?= csrf_field() ?>
            <label class="block text-sm font-medium text-gray-700">Ganti Foto Profil</label>
            <input type="file" name="foto" accept="image/*"
                   class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 w-full">
                Upload
            </button>
        </form>
    </div>

    <div class="flex-1 flex flex-col gap-8">
        <!-- Info -->
        <form action="<?= base_url('siswa/profile/update') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="<?= esc(old('username', $user['username'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100 text-base <?= (session('errors.username') ? 'border-red-400' : '') ?>">
                <?php if(session('errors.username')): ?>
                    <span class="text-red-500 text-xs"><?= session('errors.username') ?></span>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="<?= esc(old('email', $user['email'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100 text-base <?= (session('errors.email') ? 'border-red-400' : '') ?>">
                <?php if(session('errors.email')): ?>
                    <span class="text-red-500 text-xs"><?= session('errors.email') ?></span>
                <?php endif ?>
            </div>

            <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600">
                Simpan Perubahan
            </button>
        </form>

        <!-- Ganti Password -->
        <form action="<?= base_url('siswa/profile/password') ?>" method="post" class="space-y-4 bg-blue-50 rounded-xl p-6 shadow-inner">
            <?= csrf_field() ?>
            <h4 class="font-semibold text-gray-800 text-base mb-2">Ganti Password</h4>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" name="current_password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100 text-base <?= (session('errors.current_password') ? 'border-red-400' : '') ?>">
                <?php if(session('errors.current_password')): ?>
                    <span class="text-red-500 text-xs"><?= session('errors.current_password') ?></span>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="new_password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100 text-base <?= (session('errors.new_password') ? 'border-red-400' : '') ?>">
                <?php if(session('errors.new_password')): ?>
                    <span class="text-red-500 text-xs"><?= session('errors.new_password') ?></span>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100 text-base <?= (session('errors.confirm_password') ? 'border-red-400' : '') ?>">
                <?php if(session('errors.confirm_password')): ?>
                    <span class="text-red-500 text-xs"><?= session('errors.confirm_password') ?></span>
                <?php endif ?>
            </div>

            <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600">
                Ganti Password
            </button>
        </form>
    </div>
</div>

<!-- Flash Message -->
<?php if(session('success')): ?>
    <div class="fixed top-8 right-8 z-50 px-6 py-3 bg-emerald-100 text-emerald-800 rounded-xl shadow-lg animate-bounce-in">
        <?= session('success') ?>
    </div>
<?php endif ?>
<?php if(session('errors')): ?>
    <div class="fixed top-8 right-8 z-50 px-6 py-3 bg-red-100 text-red-800 rounded-xl shadow-lg animate-bounce-in">
        <?php foreach(session('errors') as $err): ?>
            <?= $err ?><br>
        <?php endforeach ?>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
