<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 border border-blue-100">
    <h2 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Nilai
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

    <form action="<?= base_url('admin/nilai/store') ?>" method="post" class="space-y-5">
        <?= csrf_field() ?>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-user-graduate"></i> Siswa
                </label>
                <select name="siswa_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.siswa_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Siswa --</option>
                    <?php foreach(($siswaList ?? []) as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= old('siswa_id') == $s['id'] ? 'selected' : '' ?>>
                            <?= esc($s['nama_lengkap']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-school"></i> Kelas
                </label>
                <select name="kelas_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.kelas_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach(($kelasList ?? []) as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= old('kelas_id') == $k['id'] ? 'selected' : '' ?>>
                            <?= esc($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-book"></i> Mapel
                </label>
                <select name="mapel_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.mapel_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Mapel --</option>
                    <?php foreach(($mapelList ?? []) as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= old('mapel_id') == $m['id'] ? 'selected' : '' ?>>
                            <?= esc($m['nama_mapel']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-user-tie"></i> Guru
                </label>
                <select name="guru_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.guru_id') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Guru --</option>
                    <?php foreach(($guruList ?? []) as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= old('guru_id') == $g['id'] ? 'selected' : '' ?>>
                            <?= esc($g['nama_lengkap']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-star"></i> Nilai Angka
                </label>
                <input type="number" name="nilai_angka" value="<?= old('nilai_angka') ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.nilai_angka') ? 'border-red-400' : '') ?>">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-star-half-stroke"></i> Nilai Huruf
                </label>
                <input type="text" name="nilai_huruf" value="<?= old('nilai_huruf') ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.nilai_huruf') ? 'border-red-400' : '') ?>">
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-calendar-alt"></i> Semester
                </label>
                <select name="semester" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.semester') ? 'border-red-400' : '') ?>">
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil" <?= old('semester') == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                    <option value="Genap" <?= old('semester') == 'Genap' ? 'selected' : '' ?>>Genap</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-calendar"></i> Tahun Ajaran
                </label>
                <input type="text" name="tahun_ajaran" value="<?= old('tahun_ajaran') ?>"
                    placeholder="misal: 2024/2025"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:border-[#6C7CF6] focus:ring-2 focus:ring-[#6C7CF6]/30 <?= (session('errors.tahun_ajaran') ? 'border-red-400' : '') ?>">
            </div>
        </div>
        <div class="flex justify-between mt-7 gap-3">
            <a href="<?= base_url('admin/nilai') ?>"
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
