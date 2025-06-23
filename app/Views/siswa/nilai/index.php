<?= $this->extend('siswa/layouts/main') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#6C7CF6] mb-1 flex items-center gap-2">
            <i class="fa-solid fa-star"></i> <?= $pageTitle ?>
        </h1>
        <p class="text-sm text-gray-500">Berikut adalah nilai-nilai yang telah Anda peroleh.</p>
    </div>

    <?php if (empty($nilaiList)): ?>
        <div class="p-5 bg-yellow-50 text-yellow-700 rounded-xl border border-yellow-200 text-center">
            🎓 Belum ada data nilai tersedia.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php foreach ($nilaiList as $n): ?>
                <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-md transition p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-sm font-semibold text-indigo-600 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-week"></i>
                            <?= esc($n['tahun_ajaran']) ?> - <?= esc($n['semester']) ?>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium">
                            Kelas <?= esc($n['kelas']) ?>
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-1"><?= esc($n['mapel']) ?></h3>
                    <p class="text-sm text-gray-600 mb-2">
                        <i class="fa-solid fa-chalkboard-user mr-1 text-blue-500"></i>
                        <?= esc($n['guru']) ?>
                    </p>

                    <div class="flex items-center justify-between mt-4">
                        <div class="text-sm text-gray-500">Nilai Angka:</div>
                        <span class="text-lg font-bold text-blue-600"><?= esc($n['nilai_angka']) ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Nilai Huruf:</div>
                        <span class="text-lg font-bold text-green-600"><?= esc($n['nilai_huruf']) ?></span>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
