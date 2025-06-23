<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-[#4F46E5] flex items-center gap-3">
        <i class="fa-solid fa-gauge-high"></i> Dashboard Guru
    </h1>
    <p class="text-gray-500 text-sm mt-1">Selamat datang kembali, pantau aktivitas mengajar dan siswa di sini.</p>
</div>

<!-- STATISTICS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-4 text-center hover:shadow-md transition">
        <div class="w-12 h-12 mx-auto flex items-center justify-center bg-white rounded-full shadow text-blue-600 text-2xl">
            <i class="fa-solid fa-users"></i>
        </div>
        <h3 class="text-2xl font-bold text-blue-700 mt-2"><?= $jumlah_siswa ?? 0 ?></h3>
        <p class="text-sm text-gray-600">Siswa Diampu</p>
    </div>

    <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl shadow-sm p-4 text-center hover:shadow-md transition">
        <div class="w-12 h-12 mx-auto flex items-center justify-center bg-white rounded-full shadow text-pink-500 text-2xl">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
        <h3 class="text-2xl font-bold text-pink-500 mt-2"><?= count($jadwal ?? []) ?></h3>
        <p class="text-sm text-gray-600">Jadwal Mengajar</p>
    </div>

    <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl shadow-sm p-4 text-center hover:shadow-md transition">
        <div class="w-12 h-12 mx-auto flex items-center justify-center bg-white rounded-full shadow text-teal-600 text-2xl">
            <i class="fa-solid fa-marker"></i>
        </div>
        <h3 class="text-2xl font-bold text-teal-600 mt-2"><?= count($nilai_terakhir ?? []) ?></h3>
        <p class="text-sm text-gray-600">Nilai Terakhir</p>
    </div>

    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl shadow-sm p-4 text-center hover:shadow-md transition">
        <div class="w-12 h-12 mx-auto flex items-center justify-center bg-white rounded-full shadow text-yellow-500 text-2xl">
            <i class="fa-solid fa-bullhorn"></i>
        </div>
        <h3 class="text-2xl font-bold text-yellow-500 mt-2"><?= count($pengumuman ?? []) ?></h3>
        <p class="text-sm text-gray-600">Pengumuman</p>
    </div>
</div>

<!-- STATISTIK PRESENSI HARI INI -->
<div class="mt-8">
    <h2 class="text-lg font-bold text-[#4F46E5] mb-4 flex items-center gap-2">
        <i class="fa-solid fa-user-check"></i> Statistik Presensi Hari Ini
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-4">
        <div class="bg-green-50 rounded-xl shadow p-4 text-center border-l-4 border-green-400">
            <div class="text-2xl font-semibold text-green-600"><?= $statistikPresensi['Hadir'] ?? 0 ?></div>
            <p class="text-sm text-gray-600 mt-1">Hadir</p>
        </div>
        <div class="bg-yellow-50 rounded-xl shadow p-4 text-center border-l-4 border-yellow-400">
            <div class="text-2xl font-semibold text-yellow-500"><?= $statistikPresensi['Izin'] ?? 0 ?></div>
            <p class="text-sm text-gray-600 mt-1">Izin</p>
        </div>
        <div class="bg-blue-50 rounded-xl shadow p-4 text-center border-l-4 border-blue-400">
            <div class="text-2xl font-semibold text-blue-600"><?= $statistikPresensi['Sakit'] ?? 0 ?></div>
            <p class="text-sm text-gray-600 mt-1">Sakit</p>
        </div>
        <div class="bg-red-50 rounded-xl shadow p-4 text-center border-l-4 border-red-400">
            <div class="text-2xl font-semibold text-red-500"><?= $statistikPresensi['Alpa'] ?? 0 ?></div>
            <p class="text-sm text-gray-600 mt-1">Alpa</p>
        </div>
    </div>
    <div class="text-right">
        <a href="<?= base_url('guru/presensi/rekap') ?>" class="inline-block bg-[#4F46E5] text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
            <i class="fa-solid fa-table-list mr-1"></i> Rekap Presensi
        </a>
    </div>
</div>

<!-- 2-COLUMN: JADWAL + NILAI -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <!-- Jadwal -->
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-lg font-bold text-[#4F46E5] mb-3 flex items-center gap-2">
            <i class="fa-solid fa-calendar-alt"></i> Jadwal Mengajar
        </h2>
        <?php if (!empty($jadwal)): ?>
            <ul class="divide-y divide-gray-200">
                <?php foreach ($jadwal as $j): ?>
                    <li class="py-3">
                        <div class="font-semibold text-blue-700"><?= esc($j['hari']) ?></div>
                        <div class="text-sm text-gray-600"><?= date('H:i', strtotime($j['jam_mulai'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?></div>
                        <div class="text-sm text-gray-500">Kelas: <?= esc($j['kelas']) ?> | Mapel: <?= esc($j['mapel']) ?></div>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php else: ?>
            <div class="text-center text-gray-400 py-8">
                <i class="fa-solid fa-calendar-xmark text-2xl mb-2"></i><br>
                Tidak ada jadwal minggu ini.
            </div>
        <?php endif ?>
    </div>

    <!-- Nilai Terakhir -->
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-lg font-bold text-[#4F46E5] mb-3 flex items-center gap-2">
            <i class="fa-solid fa-marker"></i> Nilai Terakhir Diinput
        </h2>
        <?php if (!empty($nilai_terakhir)): ?>
            <ul class="divide-y divide-gray-200">
                <?php foreach ($nilai_terakhir as $n): ?>
                    <li class="py-3">
                        <div class="font-semibold text-gray-800">Siswa ID: <?= esc($n['siswa_id']) ?></div>
                        <div class="text-sm text-gray-600">Nilai: <?= esc($n['nilai_angka']) ?> (<?= esc($n['nilai_huruf']) ?>)</div>
                        <div class="text-xs text-gray-400"><?= date('d/m/Y', strtotime($n['created_at'])) ?></div>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php else: ?>
            <div class="text-center text-gray-400 py-8">
                <i class="fa-solid fa-marker text-2xl mb-2"></i><br>
                Belum ada nilai diinput.
            </div>
        <?php endif ?>
    </div>
</div>

<!-- Pengumuman -->
<div class="mt-8 bg-white rounded-xl shadow p-5">
    <h2 class="text-lg font-bold text-[#4F46E5] mb-3 flex items-center gap-2">
        <i class="fa-solid fa-bullhorn"></i> Pengumuman Terbaru
    </h2>

    <?php if (!empty($pengumuman)): ?>
        <ul class="divide-y divide-gray-200">
            <?php foreach ($pengumuman as $p): ?>
                <li class="py-3">
                    <div class="font-bold text-gray-800"><?= esc($p['judul']) ?></div>
                    <div class="text-xs text-gray-400"><?= date('d/m/Y', strtotime($p['created_at'])) ?></div>
                    <div class="text-sm text-gray-600 mt-1"><?= esc($p['isi']) ?></div>
                </li>
            <?php endforeach ?>
        </ul>
    <?php else: ?>
        <div class="text-center text-gray-400 py-8">
            <i class="fa-solid fa-bullhorn text-2xl mb-2"></i><br>
            Tidak ada pengumuman.
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
