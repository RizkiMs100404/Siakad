<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 border border-blue-100">
    <h2 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Jadwal
    </h2>
    <?php if(session('errors')): ?>
        <div class="mb-4 px-4 py-3 bg-red-50 text-red-700 rounded-lg shadow flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
            <?php foreach(session('errors') as $err): ?>
                <?= $err ?><br>
            <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>


    <form action="<?= base_url('admin/jadwal/store') ?>" method="post" class="space-y-5">
        <?= csrf_field() ?>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-school"></i> Kelas
                </label>
                <select name="kelas_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.kelas_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach(($kelasList ?? []) as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= old('kelas_id') == $k['id'] ? 'selected' : '' ?>>
                            <?= esc($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-book"></i> Mapel
                </label>
                <select name="mapel_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.mapel_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Mapel --</option>
                    <?php foreach(($mapelList ?? []) as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= old('mapel_id') == $m['id'] ? 'selected' : '' ?>>
                            <?= esc($m['nama_mapel']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-user-tie"></i> Guru
                </label>
                <select name="guru_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.guru_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Guru --</option>
                    <?php foreach(($guruList ?? []) as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= old('guru_id') == $g['id'] ? 'selected' : '' ?>>
                            <?= esc($g['nama_lengkap']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-calendar-days"></i> Hari
                </label>
                <select name="hari" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.hari') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Hari --</option>
                    <?php 
                        $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                        $oldHari = old('hari');
                        foreach ($days as $d):
                    ?>
                    <option value="<?= $d ?>" <?= $oldHari == $d ? 'selected' : '' ?>><?= $d ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-clock"></i> Jam Mulai
                </label>
                <input type="time" name="jam_mulai" value="<?= old('jam_mulai') ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.jam_mulai') ? 'border-red-400' : '') ?>">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-regular fa-clock"></i> Jam Selesai
                </label>
                <input type="time" name="jam_selesai" value="<?= old('jam_selesai') ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 transition <?= (session('errors.jam_selesai') ? 'border-red-400' : '') ?>">
            </div>
        </div>
        <div class="flex justify-between mt-7 gap-3">
            <a href="<?= base_url('admin/jadwal') ?>"
                class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2 bg-[#6C7CF6] text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-sm">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
