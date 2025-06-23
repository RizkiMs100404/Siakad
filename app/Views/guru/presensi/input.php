<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-user-check"></i> Presensi Tanggal <?= date('d M Y', strtotime($tanggal)) ?>
</h2>

<form action="<?= base_url('guru/presensi/simpan') ?>" method="post"
      class="bg-white p-6 rounded-xl shadow border border-gray-200 space-y-6">
    <?= csrf_field() ?>
    <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
    <input type="hidden" name="mapel_id" value="<?= $mapel_id ?>">
    <input type="hidden" name="tanggal" value="<?= $tanggal ?>">

    <div class="overflow-x-auto">
        <table class="w-full text-sm border rounded-xl overflow-hidden">
            <thead class="bg-blue-100 text-left text-gray-700">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Siswa</th>
                    <th class="px-4 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php foreach ($siswa as $i => $s): ?>
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2"><?= $i + 1 ?></td>
                        <td class="px-4 py-2"><?= esc($s['nama_lengkap']) ?></td>
                        <td class="px-4 py-2">
                            <div class="flex gap-4">
                                <?php foreach (['Hadir', 'Izin', 'Sakit', 'Alpa'] as $status): ?>
                                    <label class="inline-flex items-center gap-1 text-sm text-gray-700">
                                        <input type="radio"
                                               name="keterangan[<?= $s['id'] ?>]"
                                               value="<?= $status ?>"
                                               required
                                               class="text-blue-600 focus:ring-blue-500">
                                        <?= $status ?>
                                    </label>
                                <?php endforeach ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="text-right">
        <button type="submit"
                class="mt-4 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-medium shadow transition">
            ✅ Simpan Presensi
        </button>
    </div>
</form>

<?= $this->endSection() ?>
