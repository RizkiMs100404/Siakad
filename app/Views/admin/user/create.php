<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 border border-blue-100">
    <h2 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
        <i class="fa-solid fa-user-plus"></i> Tambah User
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

    <form action="<?= base_url('admin/manajemen-akun/store') ?>" method="post" enctype="multipart/form-data" class="space-y-5">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-user"></i> Username
            </label>
            <input type="text" name="username" value="<?= old('username') ?>" autofocus
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.username') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-envelope"></i> Email
            </label>
            <input type="email" name="email" value="<?= old('email') ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.email') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-lock"></i> Password
            </label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.password') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-users-gear"></i> Role
            </label>
            <select name="role" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.role') ? 'border-red-400' : '') ?>">
                <option value="">-- Pilih Role --</option>
                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="guru" <?= old('role') == 'guru' ? 'selected' : '' ?>>Guru</option>
                <option value="siswa" <?= old('role') == 'siswa' ? 'selected' : '' ?>>Siswa</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-image"></i> Foto (opsional)
            </label>
            <input type="file" name="foto" accept="image/*"
                class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
        </div>
        <div class="flex justify-between mt-7 gap-3">
            <a href="<?= base_url('admin/manajemen-akun') ?>"
                class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2 bg-[#6C7CF6] text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-sm">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
