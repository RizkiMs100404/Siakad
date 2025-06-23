<?php
$uri = service('uri')->getPath();

function menu_active($url) {
    $curr = service('uri')->getPath();
    return (stripos($curr, $url) !== false) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-700';
}
?>
<aside id="sidebar" class="fixed inset-y-0 left-0 flex flex-col w-64 p-0 my-4 bg-white shadow-xl z-50 rounded-2xl xl:ml-6 -translate-x-full xl:translate-x-0 transition-transform duration-300">
    <!-- Logo dan close btn -->
     <div class="relative flex items-center justify-between h-16 px-6 py-4">
    <a class="flex items-center space-x-2 text-xs whitespace-nowrap text-slate-700" href="<?= base_url('guru/dashboard') ?>">
        <img src="<?= base_url('assets/images/logo.png') ?>" class="h-10" alt="main_logo" />
        <span class="ml-1 font-bold text-sm xl:text-base leading-snug">
            SIAKAD IZHHAARUL <br> HAQ-ANCOL
        </span>
    </a>
    <button class="xl:hidden absolute top-0 right-0 p-4 opacity-50" aria-label="Close Sidenav"
        onclick="document.getElementById('sidebar').classList.add('-translate-x-full')">
        <i class="fa-solid fa-xmark text-slate-400"></i>
    </button>
</div>
    <hr class="h-px bg-gradient-to-r from-transparent via-black/40 to-transparent mb-2" />
    <!-- Menu -->
    <div class="flex-1 px-2 py-2 overflow-y-auto custom-scrollbar" style="max-height: calc(100vh - 7rem)">
        <ul class="flex flex-col gap-1 pb-6">
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('guru/dashboard') ?>"
                   href="<?= base_url('guru/dashboard') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-blue-200">
                        <i class="fa-solid fa-gauge-high text-blue-500 text-base"></i>
                    </span>
                    Dashboard
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('guru/jadwal') ?>"
                   href="<?= base_url('guru/jadwal') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-pink-100">
                        <i class="fa-solid fa-calendar-days text-pink-500"></i>
                    </span>
                    Jadwal Mengajar
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('guru/nilai') ?>"
                   href="<?= base_url('guru/nilai') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-teal-100">
                        <i class="fa-solid fa-marker text-teal-500"></i>
                    </span>
                    Input & Rekap Nilai
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('guru/siswa') ?>"
                   href="<?= base_url('guru/siswa') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-blue-100">
                        <i class="fa-solid fa-user-graduate text-blue-600"></i>
                    </span>
                    Data Siswa
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('guru/pengumuman') ?>"
                   href="<?= base_url('guru/pengumuman') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-yellow-100">
                        <i class="fa-solid fa-bullhorn text-yellow-500 text-base"></i>
                    </span>
                    Pengumuman
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('guru/presensi') ?>"
                   href="<?= base_url('guru/presensi') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-green-100">
                        <i class="fa-solid fa-user-check text-green-600"></i>
                    </span>
                    Presensi
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('guru/chat') ?>"
                   href="<?= base_url('guru/chat') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-sky-100">
                        <i class="fa-solid fa-comments text-sky-600"></i>
                    </span>
                    Chat
                </a>
            </li>
        </ul>
    </div>
</aside>
