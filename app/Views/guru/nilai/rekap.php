<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-table-list"></i> Rekap Nilai
</h1>

<!-- Form Filter -->
<form method="get" class="bg-white rounded-xl shadow-md p-5 mb-8 border border-blue-100">
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Kelas</label>
            <select name="kelas_id" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelasList as $kelas): ?>
                    <option value="<?= $kelas['id'] ?>" <?= ($kelas_id == $kelas['id']) ? 'selected' : '' ?>>
                        <?= esc($kelas['nama_kelas']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Mapel</label>
            <select name="mapel_id" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($mapelList as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= (isset($_GET['mapel_id']) && $_GET['mapel_id'] == $m['id']) ? 'selected' : '' ?>>
                        <?= esc($m['nama_mapel']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="mt-5">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
            🔍 Tampilkan
        </button>
    </div>
</form>

<!-- Data Nilai -->
<?php if (!empty($dataNilai) && isset($mapel['nama_mapel'])): ?>
    <div class="bg-white rounded-xl shadow border border-gray-100 p-5">
        <div class="mb-4 text-lg font-semibold text-[#6C7CF6] flex items-center gap-2">
            <i class="fa-solid fa-book"></i> Mata Pelajaran: <?= esc($mapel['nama_mapel']) ?>
        </div>

        <div class="overflow-x-auto rounded-xl border">
            <table class="w-full text-sm text-left">
                <thead class="bg-blue-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nama Siswa</th>
                        <th class="px-4 py-2">Nilai Angka</th>
                        <th class="px-4 py-2">Nilai Huruf</th>
                        <th class="px-4 py-2">Semester</th>
                        <th class="px-4 py-2">Tahun Ajaran</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    <?php foreach ($dataNilai as $i => $n): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2"><?= $i + 1 ?></td>
                            <td class="px-4 py-2"><?= esc($siswaMap[$n['siswa_id']] ?? '—') ?></td>
                            <td class="px-4 py-2"><?= esc($n['nilai_angka']) ?></td>
                            <td class="px-4 py-2"><?= esc($n['nilai_huruf']) ?></td>
                            <td class="px-4 py-2"><?= esc($n['semester']) ?></td>
                            <td class="px-4 py-2"><?= esc($n['tahun_ajaran']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php elseif ($kelas_id && isset($_GET['mapel_id'])): ?>
    <div class="bg-yellow-50 text-yellow-700 p-4 rounded-xl border border-yellow-200 mt-6">
        ⚠️ Tidak ada data nilai untuk kelas dan mapel ini.
    </div>
<?php endif ?>

<?= $this->endSection() ?>
