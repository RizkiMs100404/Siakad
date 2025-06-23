<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
    <h2 class="text-2xl font-bold text-slate-700 flex items-center gap-2">
        <i class="fa-solid fa-users text-[#6C7CF6]"></i> <?= esc($pageTitle ?? 'Data Siswa') ?>
    </h2>
    <a href="<?= base_url('admin/siswa/create') ?>"
       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
        <i class="fa-solid fa-plus mr-2"></i> Tambah Siswa
    </a>
</div>

<?php if(session('success')): ?>
    <div class="mb-4 px-4 py-3 bg-emerald-100 text-emerald-800 rounded-lg shadow flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> <?= session('success') ?>
    </div>
<?php endif ?>
<?php if(session('errors')): ?>
    <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded-lg shadow">
        <?php foreach(session('errors') as $err): ?>
            <?= $err ?><br>
        <?php endforeach ?>
    </div>
<?php endif ?>

<!-- Search & Filter -->
<div class="mb-4 flex flex-col md:flex-row md:items-center gap-3">
    <form method="get" class="flex flex-1 items-center gap-2">
        <div class="relative w-full max-w-xs">
            <input type="text" name="search" value="<?= esc($_GET['search'] ?? '') ?>"
                placeholder="Cari Nama/NIS/NISN..." 
                class="pl-9 pr-3 py-2 w-full rounded-lg text-sm bg-gray-50 border border-gray-200 focus:border-blue-500 focus:outline-none placeholder:text-slate-400">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
        </div>
        <button class="px-4 py-2 bg-[#6C7CF6] text-white rounded-lg font-semibold hover:bg-blue-600 transition" type="submit">
            Filter
        </button>
    </form>
    <a href="<?= base_url('admin/siswa') ?>" class="text-sm text-blue-500 hover:underline">Reset</a>
</div>

<div class="overflow-x-auto bg-white rounded-2xl shadow p-4">
    <table class="min-w-full table-auto text-sm text-slate-700">
        <thead>
            <tr class="bg-[#6C7CF6]/80 text-white">
                <th class="p-3 text-left rounded-tl-xl">No</th>
                <th class="p-3 text-left">Akun</th>
                <th class="p-3 text-left">Nama Lengkap</th>
                <th class="p-3 text-left">NIS</th>
                <th class="p-3 text-left">NISN</th>
                <th class="p-3 text-left">Kelas</th>
                <th class="p-3 text-left">Jurusan</th>
                <th class="p-3 text-left">No. HP</th>
                <th class="p-3 text-left">Alamat</th>
                <th class="p-3 text-center rounded-tr-xl">Aksi</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($siswa as $i => $s): ?>
        <tr class="border-b hover:bg-blue-50/50 group">
            <td class="p-3"><?= ($pager->getCurrentPage('default') - 1) * $pager->getPerPage('default') + $i + 1 ?></td>
            <td class="p-3">
    <?php if (!empty($s['user_id']) && !empty($users[$s['user_id']])): ?>
        <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold shadow border border-blue-200">
            <?= esc($users[$s['user_id']]['username']) ?>
        </span>
    <?php else: ?>
        <span class="inline-block px-2 py-1 rounded bg-gray-100 text-gray-500 text-xs">-</span>
    <?php endif ?>
</td>

            <td class="p-3"><?= esc($s['nama_lengkap']) ?></td>
            <td class="p-3"><?= esc($s['nis']) ?></td>
            <td class="p-3"><?= esc($s['nisn']) ?></td>
            <td class="p-3"><?= esc($s['nama_kelas'] ?? '-') ?></td>
            <td class="p-3"><?= esc($s['jurusan']) ?></td>
            <td class="p-3"><?= esc($s['no_hp']) ?></td>
            <td class="p-3"><?= esc($s['alamat']) ?></td>
            <td class="p-3 text-center flex flex-row gap-2 justify-center">
                <a href="<?= base_url('admin/siswa/edit/'.$s['id']) ?>"
                   class="inline-block px-3 py-1 rounded bg-amber-400 text-white hover:bg-amber-500 transition"
                   title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                <form action="<?= base_url('admin/siswa/delete/'.$s['id']) ?>" method="post" class="inline">
                    <?= csrf_field() ?>
                    <button type="submit" onclick="return confirm('Yakin hapus siswa ini?')" 
                        class="inline-block px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 transition"
                        title="Hapus"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if (empty($siswa)): ?>
        <tr><td colspan="9" class="p-6 text-center text-gray-400">Belum ada data siswa.</td></tr>
    <?php endif ?>
</tbody>

    </table>
</div>

<div class="mt-6">
    <?= $pager->links('default', 'tailwind_custom') ?>
</div>
<?= $this->endSection() ?>
