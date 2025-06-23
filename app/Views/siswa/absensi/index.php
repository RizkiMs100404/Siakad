<?= $this->extend('siswa/layouts/main') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#6C7CF6] mb-1 flex items-center gap-2">
            <i class="fa-solid fa-user-check"></i> <?= $pageTitle ?>
        </h1>
        <p class="text-sm text-gray-500">Berikut adalah riwayat kehadiran Anda.</p>
    </div>

    <?php if (empty($presensiList)): ?>
        <div class="p-5 bg-yellow-50 text-yellow-700 rounded-xl border border-yellow-200 text-center">
            🚫 Belum ada data absensi tersedia.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php foreach ($presensiList as $p): ?>
                <?php
                    $status = strtolower($p['keterangan']);
                    $colorMap = [
                        'hadir' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-circle-check'],
                        'izin'  => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-person-walking-arrow-right'],
                        'sakit' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-notes-medical'],
                        'alpa'  => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-circle-xmark'],
                    ];
                    $clr = $colorMap[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-question'];
                ?>
                <div class="rounded-2xl p-5 shadow hover:shadow-md border border-gray-200 transition transform hover:-translate-y-1 bg-white relative overflow-hidden">
                    <!-- Badge Status -->
                    <div class="absolute top-4 left-4 flex items-center gap-2 <?= $clr['text'] ?>">
                        <i class="fa-solid <?= $clr['icon'] ?>"></i>
                        <span class="font-semibold capitalize"><?= esc($p['keterangan']) ?></span>
                    </div>

                    <!-- Date Bubble -->
                    <div class="absolute top-4 right-4 bg-gray-100 text-gray-700 px-3 py-1 text-xs rounded-full font-medium shadow-sm">
                        <?= date('d M Y', strtotime($p['tanggal'])) ?>
                    </div>

                    <!-- Main Info -->
                    <div class="mt-10">
                        <h3 class="text-lg font-bold text-gray-800 mb-1"><?= esc($p['mapel']) ?></h3>
                        <p class="text-sm text-gray-600 flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-chalkboard-user text-blue-500"></i> <?= esc($p['guru']) ?>
                        </p>
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fa-solid fa-school text-pink-500"></i> Kelas <?= esc($p['kelas']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
