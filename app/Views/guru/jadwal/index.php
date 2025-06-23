<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<!-- Heading -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-[#4F46E5] flex items-center gap-3">
        <i class="fa-solid fa-calendar-days"></i> Jadwal Mengajar
    </h1>
    <p class="text-sm text-gray-500">Daftar jadwal mengajar Anda yang sudah terjadwal.</p>
</div>

<?php if (empty($jadwal)): ?>
    <div class="bg-yellow-50 p-6 rounded-xl text-center border border-yellow-200 text-gray-600">
        <i class="fa-solid fa-circle-info text-yellow-500 text-2xl mb-2"></i><br>
        Belum ada jadwal mengajar yang tersedia.
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($jadwal as $item): ?>
            <div class="bg-white border-l-4 border-blue-500 shadow rounded-xl p-5 transition hover:shadow-md">
                <div class="flex items-center gap-2 text-blue-600 font-bold text-lg mb-2">
                    <i class="fa-solid fa-calendar-day"></i>
                    <?= esc($item['hari']) ?>
                </div>

                <div class="text-gray-700 text-sm mb-1">
                    <i class="fa-solid fa-clock mr-1 text-gray-500"></i>
                    <span class="font-medium"><?= esc($item['jam']) ?></span>
                </div>

                <div class="text-sm text-gray-700 mb-1">
                    <i class="fa-solid fa-book mr-1 text-gray-500"></i>
                    Mapel: <span class="font-semibold"><?= esc($item['mapel']) ?></span>
                </div>

                <div class="text-sm text-gray-700">
                    <i class="fa-solid fa-school mr-1 text-gray-500"></i>
                    Kelas: <span class="font-semibold"><?= esc($item['kelas']) ?></span>
                </div>

                <a href="<?= base_url('guru/jadwal/mapel/' . esc($item['mapel_id'])) ?>"
                   class="inline-block mt-4 text-sm text-blue-600 hover:underline font-medium">
                   <i class="fa-solid fa-magnifying-glass mr-1"></i> Lihat Detail Mapel
                </a>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
