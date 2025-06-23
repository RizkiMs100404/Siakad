<?php
$uri = service('uri')->getPath();

function menu_active($url) {
    $curr = service('uri')->getPath();
    return (stripos($curr, $url) !== false) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-700';
}
?>
<aside id="sidebar" class="fixed inset-y-0 left-0 flex flex-col w-64 p-0 my-4 bg-white shadow-xl z-50 rounded-2xl xl:ml-6 -translate-x-full xl:translate-x-0 transition-transform duration-300">
    <!-- Logo dan tombol close -->
     <div class="relative flex items-center justify-between h-16 px-6 py-4">
    <a class="flex items-center space-x-2 text-xs whitespace-nowrap text-slate-700" href="<?= base_url('siswa/dashboard') ?>">
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
    
    <!-- Menu Sidebar -->
    <div class="flex-1 px-2 py-2 overflow-y-auto custom-scrollbar" style="max-height: calc(100vh - 7rem)">
        <ul class="flex flex-col gap-1 pb-6">
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('siswa/dashboard') ?>"
                   href="<?= base_url('siswa/dashboard') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-blue-200">
                        <i class="fa-solid fa-gauge-high text-blue-500 text-base"></i>
                    </span>
                    Dashboard
                </a>
            </li>

            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('siswa/jadwal') ?>"
                   href="<?= base_url('siswa/jadwal') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-pink-100">
                        <i class="fa-solid fa-calendar-days text-pink-500"></i>
                    </span>
                    Jadwal Pelajaran
                </a>
            </li>

            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('siswa/nilai') ?>"
                   href="<?= base_url('siswa/nilai') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-green-100">
                        <i class="fa-solid fa-file-lines text-green-600"></i>
                    </span>
                    Nilai
                </a>
            </li>

            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('siswa/absensi') ?>"
                   href="<?= base_url('siswa/absensi') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-yellow-100">
                        <i class="fa-solid fa-user-check text-yellow-500"></i>
                    </span>
                    Absensi
                </a>
            </li>

            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('siswa/pengumuman') ?>"
                   href="<?= base_url('siswa/pengumuman') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-orange-100">
                        <i class="fa-solid fa-bullhorn text-orange-500"></i>
                    </span>
                    Pengumuman
                </a>
            </li>

            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('siswa/chat') ?>"
                   href="<?= base_url('siswa/chat') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-sky-100">
                        <i class="fa-solid fa-comments text-sky-600"></i>
                    </span>
                    Chat
                </a>
            </li>
        </ul>
    </div>
</aside>
