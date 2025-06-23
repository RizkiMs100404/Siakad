<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 border border-amber-100">
    <h2 class="text-2xl font-bold mb-6 text-amber-500 flex items-center gap-2">
        <i class="fa-solid fa-pen-to-square"></i> Edit Kelas
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

    <form action="<?= base_url('admin/kelas/update/'.$kelas['id']) ?>" method="post" class="space-y-5">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-school"></i> Nama Kelas
            </label>
            <input type="text" name="nama_kelas" value="<?= old('nama_kelas', $kelas['nama_kelas']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.nama_kelas') ? 'border-red-400' : '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="fa-solid fa-user-tie"></i> Wali Kelas (Guru)
            </label>
            <select name="guru_id"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-100/40 transition <?= (session('errors.guru_id') ? 'border-red-400' : '') ?>">
                <option value="">-- Pilih Guru --</option>
                <?php foreach($guruList as $guru): ?>
                    <option value="<?= $guru['id'] ?>" <?= old('guru_id', $kelas['guru_id']) == $guru['id'] ? 'selected' : '' ?>>
                        <?= esc($guru['nama_lengkap']) ?>
                    </option>
                <?php endforeach ?>
            </select>
            <?php if(session('errors.guru_id')): ?>
                <span class="text-red-500 text-xs"><?= session('errors.guru_id') ?></span>
            <?php endif ?>
        </div>
        <div class="flex justify-between mt-7 gap-3">
            <a href="<?= base_url('admin/kelas') ?>"
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
