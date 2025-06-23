<?= $this->extend('siswa/layouts/main') ?>
<?= $this->section('content') ?>

<!-- Statistik Atas -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <!-- Presensi Terakhir -->
    <div class="bg-white border border-green-100 rounded-2xl p-5 shadow hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                <i class="fa-solid fa-user-check text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1 font-medium">Presensi Terakhir</p>
                <?php if ($presensi): ?>
                    <p class="text-base font-bold text-gray-800"><?= date('d M Y', strtotime($presensi['tanggal'])) ?></p>
                    <span class="text-sm font-semibold <?= match(strtolower($presensi['keterangan'])) {
                        'hadir' => 'text-green-600',
                        'izin' => 'text-yellow-500',
                        'sakit' => 'text-blue-500',
                        default => 'text-red-600'
                    } ?>"><?= esc($presensi['keterangan']) ?></span>
                <?php else: ?>
                    <p class="text-sm text-gray-400">Belum ada presensi</p>
                <?php endif ?>
            </div>
        </div>
    </div>

    <!-- Nilai Terbaru -->
    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                <i class="fa-solid fa-star text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1 font-medium">Nilai Terbaru</p>
                <?php if ($nilai_terakhir): ?>
                    <p class="text-base font-bold text-gray-800">
                        <?= esc($nilai_terakhir[0]['nilai_angka']) ?> 
                        (<?= esc($nilai_terakhir[0]['nilai_huruf']) ?>)
                    </p>
                    <p class="text-sm text-gray-400"><?= date('d M Y', strtotime($nilai_terakhir[0]['created_at'])) ?></p>
                <?php else: ?>
                    <p class="text-sm text-gray-400">Belum ada nilai</p>
                <?php endif ?>
            </div>
        </div>
    </div>

    <!-- Statistik Kehadiran -->
    <div class="bg-white border border-blue-100 rounded-2xl p-5 shadow hover:shadow-lg transition col-span-2">
        <h4 class="text-sm font-semibold text-slate-600 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-chart-simple text-blue-500"></i> Statistik Kehadiran
        </h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="bg-green-50 rounded-xl p-3">
                <p class="text-xs text-green-600 font-medium">Hadir</p>
                <p class="text-xl font-bold text-green-700"><?= $countHadir ?? 0 ?></p>
            </div>
            <div class="bg-yellow-50 rounded-xl p-3">
                <p class="text-xs text-yellow-600 font-medium">Izin</p>
                <p class="text-xl font-bold text-yellow-700"><?= $countIzin ?? 0 ?></p>
            </div>
            <div class="bg-blue-50 rounded-xl p-3">
                <p class="text-xs text-blue-600 font-medium">Sakit</p>
                <p class="text-xl font-bold text-blue-700"><?= $countSakit ?? 0 ?></p>
            </div>
            <div class="bg-red-50 rounded-xl p-3">
                <p class="text-xs text-red-600 font-medium">Alpa</p>
                <p class="text-xl font-bold text-red-700"><?= $countAlpa ?? 0 ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal Pelajaran -->
<div class="bg-white border border-blue-100 shadow-md rounded-2xl mb-8 overflow-hidden">
    <div class="flex justify-between items-center px-6 pt-6 pb-3">
        <h3 class="text-base font-bold text-slate-700 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days text-blue-500"></i> Jadwal Pelajaran
        </h3>
    </div>
    <?php if ($jadwal): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-50 text-blue-600">
                    <tr>
                        <th class="py-3 px-6">Hari</th>
                        <th class="px-6">Jam</th>
                        <th class="px-6">Mapel</th>
                        <th class="px-6">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $j): ?>
                        <tr class="border-t hover:bg-blue-50 transition">
                            <td class="py-3 px-6"><?= esc($j['hari']) ?></td>
                            <td class="px-6"><?= esc($j['jam_mulai']) ?> - <?= esc($j['jam_selesai']) ?></td>
                            <td class="px-6 font-medium"><?= esc($j['mapel']) ?></td>
                            <td class="px-6"><?= esc($j['kelas']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="px-6 pb-6 text-gray-400 text-sm">Belum ada jadwal tersedia.</div>
    <?php endif ?>
</div>

<!-- Pengumuman -->
<div class="bg-white border border-yellow-100 shadow-md rounded-2xl p-6 mb-6">
    <div class="flex items-center mb-4">
        <i class="fa-solid fa-bullhorn text-yellow-500 mr-2"></i>
        <h3 class="text-base font-bold text-gray-700">Pengumuman Terbaru</h3>
    </div>
    <?php if ($pengumuman): ?>
        <ul class="divide-y divide-gray-100 text-sm text-gray-700">
            <?php foreach ($pengumuman as $p): ?>
                <li class="py-3">
                    <div class="font-semibold"><?= esc($p['judul']) ?></div>
                    <div class="text-xs text-gray-400"><?= date('d M Y', strtotime($p['created_at'])) ?></div>
                </li>
            <?php endforeach ?>
        </ul>
    <?php else: ?>
        <div class="text-sm text-gray-400">Belum ada pengumuman.</div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
