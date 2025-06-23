<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-4 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-bullhorn"></i> Pengumuman
</h2>

<!-- FLASH MESSAGE -->
<?php if(session('success')): ?>
    <div class="mb-4 px-4 py-3 bg-emerald-100 text-emerald-800 rounded-xl shadow animate-fade-in">
        <?= session('success') ?>
    </div>
<?php endif ?>
<?php if(session('errors')): ?>
    <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded-xl shadow animate-fade-in">
        <?php foreach((array)session('errors') as $err): ?>
            <?= $err ?><br>
        <?php endforeach ?>
    </div>
<?php endif ?>

<!-- Search & Add -->
<div class="flex flex-wrap gap-2 mb-4">
    <form method="get" class="flex items-center gap-2">
        <div class="relative">
            <input type="text" name="search" value="<?= esc($_GET['search'] ?? '') ?>" placeholder="Cari pengumuman..."
                class="pl-9 pr-3 py-2 w-64 rounded-lg text-sm bg-gray-50 border border-gray-200 focus:border-blue-500 focus:outline-none placeholder:text-slate-400">
            <span class="absolute left-2 top-1/2 -translate-y-1/2 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
        </div>
        <button class="px-4 py-2 bg-[#6C7CF6] text-white rounded-lg font-semibold hover:bg-blue-600 transition" type="submit">
            Cari
        </button>
        <a href="<?= base_url('admin/pengumuman/create') ?>"
            class="ml-2 px-4 py-2 bg-emerald-500 text-white rounded-lg font-semibold flex items-center gap-1 hover:bg-emerald-600 transition shadow">
            <i class="fa-solid fa-plus"></i> Tambah
        </a>
    </form>
</div>

<div class="bg-white rounded-2xl shadow p-4 overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-slate-700">
        <thead>
            <tr class="bg-[#6C7CF6]/80 text-white">
                <th class="p-3 text-left rounded-tl-xl">No</th>
                <th class="p-3 text-left">Judul</th>
                <th class="p-3 text-left">Isi</th>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Author</th>
                <th class="p-3 text-left rounded-tr-xl">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pengumuman as $i => $p): ?>
            <tr class="border-b">
                <td class="p-3"><?= ($pager->getCurrentPage('pengumuman') - 1) * 5 + $i + 1 ?></td>
                <td class="p-3 font-semibold"><?= esc($p['judul']) ?></td>
                <td class="p-3">
    <?= strlen(strip_tags($p['isi'])) > 60 ? substr(strip_tags($p['isi']), 0, 57) . '...' : strip_tags($p['isi']) ?>
</td>

                <td class="p-3"><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                <td class="p-3"><?= esc($p['author']) ?></td>
                <td class="p-3 flex gap-2">
                    <a href="<?= base_url('admin/pengumuman/edit/'.$p['id']) ?>"
                        class="px-3 py-1 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition text-xs font-semibold">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="<?= base_url('admin/pengumuman/delete/'.$p['id']) ?>" method="post" onsubmit="return confirm('Yakin hapus?')" class="inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-xs font-semibold">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php if(empty($pengumuman)): ?>
        <div class="p-5 text-center text-gray-400">Belum ada pengumuman</div>
    <?php endif ?>
</div>

<div class="mt-4">
    <?= $pager->links('pengumuman', 'tailwind_custom') ?>
</div>



<?= $this->endSection() ?>
