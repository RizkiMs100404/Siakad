<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-[#4F46E5] flex items-center gap-3">
        <i class="fa-solid fa-book-open-reader"></i> Detail Mapel
    </h1>
    <p class="text-sm text-gray-500">Informasi lengkap mengenai mata pelajaran ini.</p>
</div>

<!-- Detail Box -->
<div class="bg-white rounded-xl shadow p-6 border-l-4 border-indigo-500">
    <div class="mb-4">
        <h2 class="text-2xl font-semibold text-indigo-700">
            <?= esc($mapel['nama_mapel']) ?>
        </h2>
    </div>

    <div class="text-gray-700 space-y-2 text-sm md:text-base">
        <p><i class="fa-solid fa-chalkboard-user mr-2 text-indigo-500"></i> Guru: <strong>Anda sendiri</strong></p>
        <p><i class="fa-solid fa-people-group mr-2 text-indigo-500"></i> Diajarkan di Kelas:</p>
        <ul class="list-disc list-inside ml-1">
            <?php foreach ($kelasList as $kelas): ?>
                <li class="ml-3 text-gray-800"><?= esc($kelas) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>

<!-- Back Link -->
<a href="<?= base_url('guru/jadwal') ?>" class="inline-block mt-6 text-sm text-blue-600 hover:underline transition">
    ← Kembali ke Jadwal
</a>

<?= $this->endSection() ?>
