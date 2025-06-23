<?= $this->extend('siswa/layouts/main') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#6C7CF6] mb-2 flex items-center gap-2">
            <i class="fa-solid fa-bullhorn"></i> Daftar Pengumuman
        </h1>
        <p class="text-sm text-gray-500">Informasi terbaru yang perlu Anda ketahui.</p>
    </div>

    <?php if (session('success')): ?>
        <div class="mb-4 px-4 py-3 bg-emerald-100 text-emerald-800 rounded-xl shadow">
            <?= session('success') ?>
        </div>
    <?php endif ?>

    <?php if (!empty($pengumuman)): ?>
        <div class="space-y-4">
            <?php foreach ($pengumuman as $p): ?>
                <div class="relative border border-gray-200 rounded-xl bg-white shadow-sm p-5 hover:shadow-md transition">
                    <div class="flex items-start gap-4">
                        <div class="text-blue-600 mt-1">
                            <i class="fa-solid fa-bell text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-blue-800 hover:underline cursor-pointer">
                                <?= esc($p['judul']) ?>
                            </h3>
                            <p class="text-sm text-gray-500 mb-2">
                                Oleh <span class="font-semibold"><?= esc($p['author']) ?></span>
                                • <?= date('d M Y', strtotime($p['created_at'])) ?>
                            </p>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                <?= esc($p['isi']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <div class="p-5 bg-yellow-50 text-yellow-700 rounded-xl border border-yellow-200 text-center">
            📢 Belum ada pengumuman yang tersedia.
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
