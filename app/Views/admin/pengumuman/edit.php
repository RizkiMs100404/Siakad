<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-8">
    <h2 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
        <i class="fa-solid fa-pen"></i> Edit Pengumuman
    </h2>

    <?php if(session('errors')): ?>
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded-lg shadow">
            <?php foreach((array)session('errors') as $err): ?>
                <?= $err ?><br>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <form action="<?= base_url('admin/pengumuman/update/'.$pengumuman['id']) ?>" method="post" class="space-y-4">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
            <input type="text" name="judul" value="<?= esc(old('judul', $pengumuman['judul'])) ?>" autofocus
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Isi</label>
            <textarea name="isi" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100"><?= esc(old('isi', $pengumuman['isi'])) ?></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="<?= esc(old('tanggal', $pengumuman['tanggal'])) ?>"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100">
        </div>
        <div class="flex justify-between mt-6">
            <a href="<?= base_url('admin/pengumuman') ?>" class="inline-block px-4 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300 transition">Kembali</a>
            <button type="submit" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
