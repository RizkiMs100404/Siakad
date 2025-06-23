<?= $this->extend('siswa/layouts/main') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#6C7CF6] mb-1 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days"></i> <?= $pageTitle ?>
        </h1>
        <p class="text-sm text-gray-500">Jadwal pelajaran Anda ditampilkan berdasarkan hari.</p>
    </div>

    <?php if (empty($jadwal)): ?>
        <div class="p-5 bg-yellow-50 text-yellow-700 rounded-xl border border-yellow-200 text-center">
            📅 Belum ada jadwal tersedia.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($jadwal as $item): ?>
                <div class="bg-white rounded-xl border border-gray-200 shadow hover:shadow-md transition p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2 text-indigo-600 font-semibold text-sm">
                            <i class="fa-solid fa-calendar-day"></i>
                            <?= esc($item['hari']) ?>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium">
                            <?= esc($item['jam_mulai']) ?> - <?= esc($item['jam_selesai']) ?>
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-1"><?= esc($item['mapel']) ?></h3>
                    <p class="text-sm text-gray-600">
                        <i class="fa-solid fa-chalkboard-user mr-1 text-blue-500"></i>
                        <?= esc($item['guru']) ?>
                    </p>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
