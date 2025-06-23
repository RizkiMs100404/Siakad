<?php
$uri = service('uri')->getPath();

function menu_active($url) {
    $curr = service('uri')->getPath();
    return (stripos($curr, $url) !== false) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-700';
}
function menu_dropdown_active($uris = []) {
    $curr = service('uri')->getPath();
    foreach ($uris as $uri) {
        if (stripos($curr, $uri) !== false) return true;
    }
    return false;
}
?>
<aside id="sidebar" class="fixed inset-y-0 left-0 flex flex-col w-64 p-0 my-4 bg-white shadow-xl z-50 rounded-2xl xl:ml-6 -translate-x-full xl:translate-x-0 transition-transform duration-300">
    <!-- Logo dan close btn -->
    <div class="relative flex items-center justify-between h-16 px-6 py-4">
    <a class="flex items-center space-x-2 text-xs whitespace-nowrap text-slate-700" href="<?= base_url('admin/dashboard') ?>">
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
    <!-- Menu (add overflow-y-auto for scroll) -->
    <div class="flex-1 px-2 py-2 overflow-y-auto custom-scrollbar" style="max-height: calc(100vh - 7rem)">
        <ul class="flex flex-col gap-1 pb-6">
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('admin/dashboard') ?>"
                   href="<?= base_url('admin/dashboard') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-blue-200">
                        <i class="fa-solid fa-gauge-high text-blue-500 text-base"></i>
                    </span>
                    Dashboard
                </a>
            </li>
            <!-- Data Master Dropdown -->
            <li>
                <?php $dropdownActive = menu_dropdown_active(['guru','siswa','kelas','jadwal','mapel','nilai']); ?>
                <button type="button"
                    class="flex items-center gap-2 w-full px-3 py-2 rounded-lg font-medium transition-colors text-sm focus:outline-none
                    <?= $dropdownActive ? 'bg-orange-100 text-orange-700 font-semibold' : 'text-slate-700' ?>"
                    onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.chev').classList.toggle('fa-chevron-down'); this.querySelector('.chev').classList.toggle('fa-chevron-right');">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-orange-100">
                        <i class="fa-solid fa-layer-group text-orange-500 text-base"></i>
                    </span>
                    Data Master
                    <i class="fa-solid chev <?= $dropdownActive ? 'fa-chevron-down' : 'fa-chevron-right' ?> ml-auto transition-transform duration-200 text-xs"></i>
                </button>
                <!-- Inline Dropdown -->
                <ul class="ml-2 mt-1 flex flex-col gap-1 <?= $dropdownActive ? '' : 'hidden' ?>">
                    <li>
                        <a href="<?= base_url('admin/guru') ?>"
                           class="flex items-center gap-2 px-7 py-2 rounded-lg text-sm font-medium transition
                           <?= menu_active('admin/guru') ?> hover:bg-orange-100">
                            <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-lime-200">
                                <i class="fa-solid fa-user-tie text-lime-600"></i>
                            </span>
                            Data Guru
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/siswa') ?>"
                           class="flex items-center gap-2 px-7 py-2 rounded-lg text-sm font-medium transition
                           <?= menu_active('admin/siswa') ?> hover:bg-orange-100">
                            <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-blue-100">
                                <i class="fa-solid fa-user-graduate text-blue-600"></i>
                            </span>
                            Siswa
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/kelas') ?>"
                           class="flex items-center gap-2 px-7 py-2 rounded-lg text-sm font-medium transition
                           <?= menu_active('admin/kelas') ?> hover:bg-orange-100">
                            <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-purple-100">
                                <i class="fa-solid fa-school text-purple-600"></i>
                            </span>
                            Kelas
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/jadwal') ?>"
                           class="flex items-center gap-2 px-7 py-2 rounded-lg text-sm font-medium transition
                           <?= menu_active('admin/jadwal') ?> hover:bg-orange-100">
                            <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-pink-100">
                                <i class="fa-solid fa-calendar-days text-pink-500"></i>
                            </span>
                            Jadwal
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/mapel') ?>"
                           class="flex items-center gap-2 px-7 py-2 rounded-lg text-sm font-medium transition
                           <?= menu_active('admin/mapel') ?> hover:bg-orange-100">
                            <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-indigo-100">
                                <i class="fa-solid fa-book-open text-indigo-600"></i>
                            </span>
                            Mapel
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/nilai') ?>"
                           class="flex items-center gap-2 px-7 py-2 rounded-lg text-sm font-medium transition
                           <?= menu_active('admin/nilai') ?> hover:bg-orange-100">
                            <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-teal-100">
                                <i class="fa-solid fa-marker text-teal-500"></i>
                            </span>
                            Nilai
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('admin/manajemen-akun') ?>"
                    href="<?= base_url('admin/manajemen-akun') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-emerald-100">
                        <i class="fa-solid fa-users-gear text-emerald-500 text-base"></i>
                    </span>
                    Manajemen Akun
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('admin/pengumuman') ?> "
                    href="<?= base_url('admin/pengumuman') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-yellow-100">
                        <i class="fa-solid fa-bullhorn text-yellow-500 text-base"></i>
                    </span>
                    Pengumuman
                </a>
            </li>
            <li>
                <a class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium transition-colors text-sm <?= menu_active('admin/laporan') ?> "
                    href="<?= base_url('admin/laporan/rekap') ?>">
                    <span class="flex items-center justify-center h-7 w-7 rounded-lg bg-cyan-100">
                        <i class="fa-solid fa-file-lines text-cyan-500 text-base"></i>
                    </span>
                    Laporan
                </a>
            </li>
        </ul>
    </div>
</aside>