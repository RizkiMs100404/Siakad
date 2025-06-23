<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-6 text-[#6C7CF6] flex items-center gap-2">
    <i class="fa-solid fa-bullhorn"></i> Daftar Pengumuman
</h1>

<a href="<?= base_url('guru/pengumuman/create') ?>"
   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow inline-block mb-6 transition">
   + Tambah Pengumuman
</a>

<?php if (session('success')): ?>
    <div class="mb-4 px-4 py-3 bg-emerald-100 text-emerald-800 rounded-xl shadow">
        <?= session('success') ?>
    </div>
<?php endif ?>

<?php if (!empty($pengumuman)): ?>
    <div class="grid gap-6">
        <?php foreach ($pengumuman as $p): ?>
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="text-lg font-semibold text-blue-700">
                            <?= esc($p['judul']) ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Oleh <span class="font-medium"><?= esc($p['author']) ?></span>
                            • <?= date('d M Y', strtotime($p['created_at'])) ?>
                        </p>
                    </div>
                </div>

                <p class="text-gray-700 mb-4 leading-relaxed">
                    <?= esc($p['isi']) ?>
                </p>

                <div class="flex gap-3">
                    <a href="<?= base_url('guru/pengumuman/edit/'.$p['id']) ?>"
                       class="text-sm text-blue-600 hover:underline">
                        ✏️ Edit
                    </a>
                    <form action="<?= base_url('guru/pengumuman/delete/'.$p['id']) ?>" method="post"
                          onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="text-sm text-red-600 hover:underline">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <div class="p-5 bg-yellow-50 text-yellow-700 rounded-xl border border-yellow-200">
        📢 Belum ada pengumuman yang tersedia.
    </div>
<?php endif ?>

<?= $this->endSection() ?>
