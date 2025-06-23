<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 border border-amber-100">
    <h2 class="text-2xl font-bold mb-6 text-amber-500 flex items-center gap-2">
        <i class="fa-solid fa-pen-to-square"></i> Edit User
    </h2>
    <?php if(session('errors')): ?>
        <div class="mb-4 px-4 py-3 bg-red-50 text-red-700 rounded-lg shadow flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
            <?php foreach(session('errors') as $err): ?>
                <?= $err ?><br>
            <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <form action="<?= base_url('admin/manajemen-akun/update/'.$user['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-5">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-user"></i> Username
            </label>
            <input type="text" name="username" value="<?= old('username', $user['username']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.username') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-envelope"></i> Email
            </label>
            <input type="email" name="email" value="<?= old('email', $user['email']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.email') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-lock"></i> Password <span class="text-xs text-gray-400">(Kosongkan jika tidak ingin ganti password)</span>
            </label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.password') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-users-gear"></i> Role
            </label>
            <select name="role" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.role') ? 'border-red-400' : '') ?>">
                <option value="">-- Pilih Role --</option>
                <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="guru" <?= old('role', $user['role']) == 'guru' ? 'selected' : '' ?>>Guru</option>
                <option value="siswa" <?= old('role', $user['role']) == 'siswa' ? 'selected' : '' ?>>Siswa</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-image"></i> Foto (opsional)
            </label>
            <input type="file" name="foto" accept="image/*"
                class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            <div class="mt-2">
                <img src="<?= base_url('uploads/user/'.($user['foto'] ?: 'default.png')) ?>"
                     alt="<?= esc($user['username']) ?>" class="h-16 w-16 rounded-full object-cover border border-blue-100 shadow">
            </div>
        </div>
        <div class="flex justify-between mt-7 gap-3">
            <a href="<?= base_url('admin/manajemen-akun') ?>"
                class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition shadow-sm">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
