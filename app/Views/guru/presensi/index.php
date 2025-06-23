<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-calendar-check"></i> Input Presensi
</h2>

<form action="<?= base_url('guru/presensi/load') ?>" method="post"
      class="bg-white p-6 rounded-xl shadow border border-gray-200 space-y-5">
    <?= csrf_field() ?>

    <div class="grid md:grid-cols-3 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <select name="mapel_id"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($mapel as $m): ?>
                    <option value="<?= $m['id'] ?>"><?= esc($m['nama_mapel']) ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="kelas_id"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id'] ?>"><?= esc($k['nama_kelas']) ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Presensi</label>
            <input type="date" name="tanggal"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>
    </div>

    <div class="pt-4">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg shadow transition">
            ➕ Lanjut
        </button>
    </div>
</form>

<?= $this->endSection() ?>
