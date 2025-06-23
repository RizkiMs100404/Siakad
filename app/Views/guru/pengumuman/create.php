<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-circle-plus"></i> Tambah Pengumuman
</h1>

<form method="post" action="<?= base_url('guru/pengumuman/store') ?>"
      class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
    <?= csrf_field() ?>

    <div class="mb-5">
        <label class="block mb-1 font-semibold text-sm text-gray-700">Judul Pengumuman</label>
        <input type="text" name="judul"
               class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
               value="<?= old('judul') ?>" placeholder="Masukkan judul pengumuman">
        <?php if (session('errors.judul')): ?>
            <div class="text-red-500 text-sm mt-1"> <?= session('errors.judul') ?> </div>
        <?php endif ?>
    </div>

    <div class="mb-5">
        <label class="block mb-1 font-semibold text-sm text-gray-700">Isi Pengumuman</label>
        <textarea name="isi" rows="6"
                  class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                  placeholder="Tulis isi pengumuman di sini..."><?= old('isi') ?></textarea>
        <?php if (session('errors.isi')): ?>
            <div class="text-red-500 text-sm mt-1"> <?= session('errors.isi') ?> </div>
        <?php endif ?>
    </div>

    <div class="flex gap-3 mt-6">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg shadow transition">
            💾 Simpan
        </button>
        <a href="<?= base_url('guru/pengumuman') ?>"
           class="text-gray-600 hover:underline flex items-center gap-1">
           ↩️ Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>
