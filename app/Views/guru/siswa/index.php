<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-users"></i> Data Siswa
</h1>

<!-- FILTER: PILIH KELAS + SEARCH -->
<form method="get" class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
            <select name="kelas_id" class="border rounded-lg px-4 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelasList as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= ($kelas_id == $k['id']) ? 'selected' : '' ?>>
                        <?= esc($k['nama_kelas']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Cari Nama Siswa</label>
            <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Nama siswa..."
                   class="border rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="pt-6 md:pt-0">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                <i class="fa-solid fa-search mr-1"></i> Tampilkan
            </button>
        </div>
    </div>
</form>

<!-- TABEL SISWA -->
<?php if (!empty($siswaList)): ?>
    <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
        <table class="w-full text-sm text-left">
            <thead class="bg-blue-100 text-gray-800">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">NIS</th>
                    <th class="px-4 py-3">NISN</th>
                    <th class="px-4 py-3">Jurusan</th>
                    <th class="px-4 py-3">No HP</th>
                    <th class="px-4 py-3">Alamat</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php foreach ($siswaList as $i => $s): ?>
                    <tr>
                        <td class="px-4 py-2"><?= $i + 1 ?></td>
                        <td class="px-4 py-2"><?= esc($s['nama_lengkap']) ?></td>
                        <td class="px-4 py-2"><?= esc($s['nis']) ?></td>
                        <td class="px-4 py-2"><?= esc($s['nisn']) ?></td>
                        <td class="px-4 py-2"><?= esc($s['jurusan']) ?></td>
                        <td class="px-4 py-2"><?= esc($s['no_hp']) ?></td>
                        <td class="px-4 py-2"><?= esc($s['alamat']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php elseif ($kelas_id): ?>
    <div class="p-5 bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-xl mt-4">
        ⚠️ Tidak ada siswa ditemukan.
    </div>
<?php endif ?>

<?= $this->endSection() ?>
