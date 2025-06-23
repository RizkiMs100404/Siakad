<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 border border-amber-100">
    <h2 class="text-2xl font-bold mb-6 text-amber-500 flex items-center gap-2">
        <i class="fa-solid fa-pen-to-square"></i> Edit Guru
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

    <form action="<?= base_url('admin/guru/update/'.$guru['id']) ?>" method="post" class="space-y-5">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-user-circle"></i> Pilih Akun Guru
            </label>
            <select name="user_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.user_id') ? 'border-red-400' : '') ?>" required>
                <option value="">-- Pilih Akun Guru --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"
                        <?= old('user_id', $guru['user_id']) == $user['id'] ? 'selected' : '' ?>>
                        <?= esc($user['username']) ?> (<?= esc($user['email']) ?>)
                    </option>
                <?php endforeach ?>
            </select>
            <?php if(session('errors.user_id')): ?>
                <div class="text-xs text-red-500"><?= session('errors.user_id') ?></div>
            <?php endif ?>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-user"></i> Nama Lengkap
            </label>
            <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap', $guru['nama_lengkap']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.nama_lengkap') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-id-card"></i> NIP
            </label>
            <input type="text" name="nip" value="<?= old('nip', $guru['nip']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.nip') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-book-open"></i> Mapel
            </label>
            <input type="text" name="mapel" value="<?= old('mapel', $guru['mapel']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.mapel') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-phone"></i> No. HP
            </label>
            <input type="text" name="no_hp" value="<?= old('no_hp', $guru['no_hp']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.no_hp') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-location-dot"></i> Alamat
            </label>
            <textarea name="alamat" rows="2"
                      class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition"><?= old('alamat', $guru['alamat']) ?></textarea>
        </div>
        <div class="flex justify-between mt-7 gap-3">
            <a href="<?= base_url('admin/guru') ?>"
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
