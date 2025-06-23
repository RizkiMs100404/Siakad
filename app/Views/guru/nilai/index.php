<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-marker"></i> Input / Edit Nilai
</h1>

<!-- Flash Success -->
<?php if (session('success')): ?>
    <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-xl shadow">
        <?= session('success') ?>
    </div>
<?php endif ?>

<!-- Form Pilihan -->
<form method="get" class="grid md:grid-cols-2 gap-4 mb-8">
    <div>
        <label class="block text-sm mb-1 font-medium">Pilih Kelas</label>
        <select name="kelas_id" class="border rounded-lg px-3 py-2 w-full">
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($kelasList as $kelas): ?>
                <option value="<?= $kelas['id'] ?>" <?= ($kelas_id == $kelas['id']) ? 'selected' : '' ?>>
                    <?= esc($kelas['nama_kelas']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div>
        <label class="block text-sm mb-1 font-medium">Pilih Mapel</label>
        <select name="mapel_id" class="border rounded-lg px-3 py-2 w-full">
            <option value="">-- Pilih Mapel --</option>
            <?php foreach ($mapelList as $mapel): ?>
                <option value="<?= $mapel['id'] ?>" <?= ($mapel_id == $mapel['id']) ? 'selected' : '' ?>>
                    <?= esc($mapel['nama_mapel']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="md:col-span-2 flex items-center gap-3 mt-2">
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            Tampilkan
        </button>

        <?php if ($kelas_id && $mapel_id): ?>
            <a href="<?= base_url("guru/nilai/rekap?kelas_id=$kelas_id&mapel_id=$mapel_id") ?>"
               class="bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">
               📊 Lihat Rekap Nilai
            </a>
        <?php endif ?>
    </div>
</form>

<!-- Form Input Nilai -->
<?php if ($kelas_id && $mapel && !empty($siswaList)): ?>
    <form action="<?= base_url('guru/nilai/simpan') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="kelas_id" value="<?= esc($kelas_id) ?>">
        <input type="hidden" name="mapel_id" value="<?= esc($mapel['id']) ?>">

        <!-- Semester & Tahun -->
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium">Semester</label>
                <select name="semester" class="w-full border rounded-lg px-3 py-2">
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" value="<?= date('Y') . '/' . (date('Y') + 1) ?>"
                       class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>

        <!-- Tabel Nilai -->
        <div class="overflow-x-auto">
            <table class="w-full border text-sm rounded-xl overflow-hidden shadow">
                <thead class="bg-blue-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama Siswa</th>
                        <th class="px-4 py-2 text-left">Nilai Angka</th>
                        <th class="px-4 py-2 text-left">Nilai Huruf</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php foreach ($siswaList as $i => $siswa): ?>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2"><?= $i + 1 ?></td>
                            <td class="px-4 py-2"><?= esc($siswa['nama_lengkap']) ?></td>
                            <td class="px-4 py-2">
                                <input type="number" min="0" max="100" required
                                       name="nilai[<?= $siswa['id'] ?>][angka]"
                                       value="<?= esc($nilaiData[$siswa['id']]['angka'] ?? '') ?>"
                                       class="border rounded px-2 py-1 w-full">
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" required
                                       name="nilai[<?= $siswa['id'] ?>][huruf]"
                                       value="<?= esc($nilaiData[$siswa['id']]['huruf'] ?? '') ?>"
                                       class="border rounded px-2 py-1 w-full">
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition">
            💾 Simpan Nilai
        </button>
    </form>
<?php elseif ($kelas_id && $mapel_id): ?>
    <div class="bg-yellow-50 text-yellow-700 p-4 rounded-lg mt-4 border border-yellow-200">
        Tidak ada siswa ditemukan untuk kelas ini.
    </div>
<?php endif ?>

<?= $this->endSection() ?>
