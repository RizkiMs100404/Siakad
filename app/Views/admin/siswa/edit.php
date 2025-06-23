<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 border border-amber-100">
    <h2 class="text-2xl font-bold mb-6 text-amber-500 flex items-center gap-2">
        <i class="fa-solid fa-pen-to-square"></i> Edit Siswa
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

    <form action="<?= base_url('admin/siswa/update/'.$siswa['id']) ?>" method="post" class="space-y-5">
        <?= csrf_field() ?>
        <div>
    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
        <i class="fa-solid fa-user-circle"></i> Pilih Akun Siswa
    </label>
    <select name="user_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30" required>
    <option value="">-- Pilih Akun Siswa --</option>
    <?php foreach ($users as $user): ?>
        <option value="<?= $user['id'] ?>"
            <?= old('user_id', $siswa['user_id']) == $user['id'] ? 'selected' : '' ?>>
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
            <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap', $siswa['nama_lengkap']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.nama_lengkap') ? 'border-red-400' : '') ?>">
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-id-card"></i> NIS
                </label>
                <input type="text" name="nis" value="<?= old('nis', $siswa['nis']) ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.nis') ? 'border-red-400' : '') ?>">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-id-card-clip"></i> NISN
                </label>
                <input type="text" name="nisn" value="<?= old('nisn', $siswa['nisn']) ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.nisn') ? 'border-red-400' : '') ?>">
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-chalkboard"></i> Kelas
                </label>
                <select name="kelas_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.kelas_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach($kelas ?? [] as $k): ?>
                        <option value="<?= $k['id'] ?>"
                            <?= old('kelas_id', $siswa['kelas_id']) == $k['id'] ? 'selected' : '' ?>>
                            <?= esc($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-building-columns"></i> Jurusan
                </label>
                <input type="text" name="jurusan" value="<?= old('jurusan', $siswa['jurusan']) ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.jurusan') ? 'border-red-400' : '') ?>">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-phone"></i> No. HP
            </label>
            <input type="text" name="no_hp" value="<?= old('no_hp', $siswa['no_hp']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.no_hp') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-location-dot"></i> Alamat
            </label>
            <textarea name="alamat" rows="2"
                      class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition"><?= old('alamat', $siswa['alamat']) ?></textarea>
        </div>
        <div class="flex justify-between mt-7 gap-3">
            <a href="<?= base_url('admin/siswa') ?>"
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
