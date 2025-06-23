<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-4 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-file-lines"></i> Rekap Data Master
</h2>
<div class="flex gap-2 mb-6">
    <?php $menus = ['guru'=>'Guru','siswa'=>'Siswa','kelas'=>'Kelas','mapel'=>'Mapel','jadwal'=>'Jadwal','nilai'=>'Nilai']; ?>
    <?php foreach ($menus as $k => $v): ?>
        <a href="<?= base_url('admin/laporan/rekap?tab='.$k) ?>"
           class="px-5 py-2 rounded-full text-sm font-semibold transition <?= $tab == $k ? 'bg-[#6C7CF6] text-white shadow' : 'bg-gray-100 text-slate-700 hover:bg-blue-100' ?>">
           <?= $v ?>
        </a>
    <?php endforeach ?>
    <a href="<?= base_url('admin/laporan/rekap/print/'.$tab) ?>" target="_blank"
        class="ml-auto px-5 py-2 rounded-full bg-blue-600 text-white font-semibold flex items-center gap-1 hover:bg-blue-700 transition shadow"><i class="fa-solid fa-print"></i> Print</a>
    <a href="<?= base_url('admin/laporan/rekap/pdf/'.$tab) ?>"
        class="px-4 py-2 rounded-full bg-red-600 text-white font-semibold flex items-center gap-1 hover:bg-red-700 transition shadow"
        target="_blank"><i class="fa-solid fa-file-pdf"></i> PDF</a>
    <a href="<?= base_url('admin/laporan/rekap/excel/'.$tab) ?>"
        class="px-4 py-2 rounded-full bg-green-600 text-white font-semibold flex items-center gap-1 hover:bg-green-700 transition shadow"
        target="_blank"><i class="fa-solid fa-file-excel"></i> Excel</a>
</div>

<!-- Search Bar -->
<form method="get" class="mb-4 flex items-center gap-2">
    <input type="hidden" name="tab" value="<?= esc($tab) ?>">
    <div class="relative max-w-xs">
        <input type="text" name="search" value="<?= esc($search) ?>"
            placeholder="Cari data..." 
            class="pl-9 pr-3 py-2 w-full rounded-lg text-sm bg-gray-50 border border-gray-200 focus:border-blue-500 focus:outline-none placeholder:text-slate-400">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
    </div>
    <button class="px-4 py-2 bg-[#6C7CF6] text-white rounded-lg font-semibold hover:bg-blue-600 transition" type="submit">
        Filter
    </button>
    <a href="<?= base_url('admin/laporan/rekap?tab='.$tab) ?>" class="text-sm text-blue-500 hover:underline">Reset</a>
</form>

<div class="bg-white rounded-2xl shadow p-4 overflow-x-auto">
    <?php if ($tab == 'guru'): ?>
        <table class="min-w-full table-auto text-sm text-slate-700">
            <thead>
                <tr class="bg-[#6C7CF6]/80 text-white">
                    <th class="p-3 text-left rounded-tl-xl">No</th>
                    <th class="p-3 text-left">Nama Lengkap</th>
                    <th class="p-3 text-left">NIP</th>
                    <th class="p-3 text-left">Mapel</th>
                    <th class="p-3 text-left">No. HP</th>
                    <th class="p-3 text-left rounded-tr-xl">Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= $i+1 ?></td>
                        <td class="p-3"><?= esc($d['nama_lengkap']) ?></td>
                        <td class="p-3"><?= esc($d['nip']) ?></td>
                        <td class="p-3"><?= esc($d['mapel'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['no_hp']) ?></td>
                        <td class="p-3"><?= esc($d['alamat']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'siswa'): ?>
        <table class="min-w-full table-auto text-sm text-slate-700">
            <thead>
                <tr class="bg-[#6C7CF6]/80 text-white">
                    <th class="p-3 text-left rounded-tl-xl">No</th>
                    <th class="p-3 text-left">Nama Lengkap</th>
                    <th class="p-3 text-left">NIS</th>
                    <th class="p-3 text-left">NISN</th>
                    <th class="p-3 text-left">Kelas</th>
                    <th class="p-3 text-left">Jurusan</th>
                    <th class="p-3 text-left">No. HP</th>
                    <th class="p-3 text-left rounded-tr-xl">Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= $i+1 ?></td>
                        <td class="p-3"><?= esc($d['nama_lengkap']) ?></td>
                        <td class="p-3"><?= esc($d['nis']) ?></td>
                        <td class="p-3"><?= esc($d['nisn']) ?></td>
                        <td class="p-3"><?= esc($d['nama_kelas'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['jurusan']) ?></td>
                        <td class="p-3"><?= esc($d['no_hp']) ?></td>
                        <td class="p-3"><?= esc($d['alamat']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'kelas'): ?>
        <table class="min-w-full table-auto text-sm text-slate-700">
            <thead>
                <tr class="bg-[#6C7CF6]/80 text-white">
                    <th class="p-3 text-left rounded-tl-xl">No</th>
                    <th class="p-3 text-left">Nama Kelas</th>
                    <th class="p-3 text-left rounded-tr-xl">Wali Kelas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= $i+1 ?></td>
                        <td class="p-3"><?= esc($d['nama_kelas']) ?></td>
                        <td class="p-3"><?= esc($d['wali_nama'] ?? '-') ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'mapel'): ?>
        <table class="min-w-full table-auto text-sm text-slate-700">
            <thead>
                <tr class="bg-[#6C7CF6]/80 text-white">
                    <th class="p-3 text-left rounded-tl-xl">No</th>
                    <th class="p-3 text-left">Nama Mapel</th>
                    <th class="p-3 text-left rounded-tr-xl">Guru Pengampu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= $i+1 ?></td>
                        <td class="p-3"><?= esc($d['nama_mapel']) ?></td>
                        <td class="p-3"><?= esc($d['nama_guru'] ?? '-') ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'jadwal'): ?>
        <table class="min-w-full table-auto text-sm text-slate-700">
            <thead>
                <tr class="bg-[#6C7CF6]/80 text-white">
                    <th class="p-3 text-left rounded-tl-xl">No</th>
                    <th class="p-3 text-left">Kelas</th>
                    <th class="p-3 text-left">Mapel</th>
                    <th class="p-3 text-left">Guru</th>
                    <th class="p-3 text-left">Hari</th>
                    <th class="p-3 text-left">Jam Mulai</th>
                    <th class="p-3 text-left rounded-tr-xl">Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= $i+1 ?></td>
                        <td class="p-3"><?= esc($d['nama_kelas'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['nama_mapel'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['nama_guru'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['hari']) ?></td>
                        <td class="p-3"><?= esc($d['jam_mulai']) ?></td>
                        <td class="p-3"><?= esc($d['jam_selesai']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'nilai'): ?>
        <table class="min-w-full table-auto text-sm text-slate-700">
            <thead>
                <tr class="bg-[#6C7CF6]/80 text-white">
                    <th class="p-3 text-left rounded-tl-xl">No</th>
                    <th class="p-3 text-left">Siswa</th>
                    <th class="p-3 text-left">Kelas</th>
                    <th class="p-3 text-left">Mapel</th>
                    <th class="p-3 text-left">Guru</th>
                    <th class="p-3 text-left">Nilai Angka</th>
                    <th class="p-3 text-left">Nilai Huruf</th>
                    <th class="p-3 text-left">Semester</th>
                    <th class="p-3 text-left rounded-tr-xl">Tahun Ajaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= $i+1 ?></td>
                        <td class="p-3"><?= esc($d['nama_siswa'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['nama_kelas'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['nama_mapel'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['nama_guru'] ?? '-') ?></td>
                        <td class="p-3"><?= esc($d['nilai_angka']) ?></td>
                        <td class="p-3"><?= esc($d['nilai_huruf']) ?></td>
                        <td class="p-3"><?= esc($d['semester']) ?></td>
                        <td class="p-3"><?= esc($d['tahun_ajaran']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
<?= $this->endSection() ?>
