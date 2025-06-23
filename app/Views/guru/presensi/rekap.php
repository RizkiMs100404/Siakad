<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-6 text-[#4F46E5] flex items-center gap-2">
    <i class="fa-solid fa-table-list"></i> Rekap Presensi
</h2>

<div class="bg-white p-5 rounded-xl shadow overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-xl text-sm">
        <thead class="bg-blue-100 text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left">📅 Tanggal</th>
                <th class="px-4 py-3 text-left">🏫 Kelas</th>
                <th class="px-4 py-3 text-left">📘 Mapel</th>
                <th class="px-4 py-3 text-left">👥 Jumlah Presensi</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $d): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3"><?= date('d M Y', strtotime($d['tanggal'])) ?></td>
                        <td class="px-4 py-3"><?= esc($kelasMap[$d['kelas_id']] ?? '-') ?></td>
                        <td class="px-4 py-3"><?= esc($mapelMap[$d['mapel_id']] ?? '-') ?></td>
                        <td class="px-4 py-3 font-semibold text-blue-600"><?= esc($d['total']) ?> siswa</td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-6">
                        <i class="fa-solid fa-circle-info text-xl"></i><br>
                        Belum ada data presensi tercatat.
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
