<nav class="w-full bg-[#6C7CF6] px-16 py-4 flex flex-col z-30">
    <!-- Breadcrumb & Title -->
    <div class="flex justify-between items-end w-full">
        <!-- Tombol Hamburger (khusus mobile) -->
        <button 
            class="block xl:hidden mr-3 text-2xl text-white focus:outline-none" 
            id="sidebarToggleBtn"
            style="position:absolute;left:16px;top:20px;z-index:60;"
        >
            <i class="fa fa-bars"></i>
        </button>

        <div>
            <!-- Breadcrumb -->
            <div class="flex items-center text-xs text-white/80 mb-0.5 font-normal gap-1">
                <i class="fa-solid fa-house mr-1"></i>
                <span class="opacity-70">Pages</span>
                <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
                    <?php foreach ($breadcrumb as $i => $item): ?>
                        <span class="mx-1">/</span>
                        <?php if ($i == count($breadcrumb) - 1): ?>
                            <span class="font-semibold text-white"><?= esc($item) ?></span>
                        <?php else: ?>
                            <span class="opacity-70"><?= esc($item) ?></span>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php else: ?>
                    <span class="mx-1">/</span>
                    <span class="font-semibold text-white">Dashboard</span>
                <?php endif ?>
            </div>
            <!-- Title -->
            <div>
                <h6 class="font-bold text-white text-lg capitalize leading-tight mt-0">
                    <?= isset($breadcrumb) && is_array($breadcrumb) ? esc(end($breadcrumb)) : 'Dashboard' ?>
                </h6>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2">
            <!-- Search -->
            <div class="relative hidden md:block w-60">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input 
    type="text" 
    id="searchInput"
    class="pl-10 pr-3 py-2 w-full rounded-lg text-sm bg-white border border-gray-200 focus:border-blue-500 focus:outline-none shadow-md placeholder:text-slate-400" 
    placeholder="Cari siswa, nilai, jadwal mengajar..."
    autocomplete="off"
/>
<div id="searchResults" class="absolute bg-white shadow-md rounded-lg mt-2 w-full z-50 hidden max-h-60 overflow-auto"></div>

            </div>

            <?php if (!session('isLoggedIn')): ?>
                <a href="<?= base_url('login') ?>" class="flex items-center gap-1 px-3 py-2 rounded-lg text-white font-semibold hover:bg-white/10 transition focus:outline-none text-sm">
                    <i class="fa-solid fa-user"></i>
                    <span class="hidden sm:block">Sign In</span>
                </a>
            <?php else: ?>
                <div class="flex items-center gap-1 px-3 py-2 rounded-lg bg-white/20 text-white font-semibold hover:bg-white/30 transition focus:outline-none text-left text-sm">
                    <i class="fa-solid fa-user"></i>
                    <span class="hidden sm:inline"><?= esc(session('username')) ?></span>
                </div>

                <!-- Notifikasi Dropdown (Chat Masuk) -->
<div class="relative">
    <button id="notifDropdownBtn" class="text-white px-2 py-2 rounded-lg hover:bg-white/10 focus:outline-none relative">
        <i class="fa-solid fa-bell text-lg"></i>
        <span id="notifBadge" class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 hidden">0</span>
    </button>
    <div id="notifDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-lg py-2 hidden z-50 border border-gray-100">
        <div class="px-4 py-2 border-b border-gray-100 font-bold text-slate-500 text-xs">Pesan Masuk</div>
        <div id="notifContent">
            <div class="px-4 py-4 text-center text-gray-400">Memuat notifikasi...</div>
        </div>
    </div>
</div>


                <div class="relative">
                    <button id="settingsDropdownBtn" class="flex items-center px-2 py-2 rounded-lg hover:bg-white/10 focus:outline-none gap-2">
                        <!-- Foto Profil User -->
                        <img src="<?= base_url('uploads/user/' . (session('user_foto') ?? 'default.png')) ?>"
                            class="w-8 h-8 rounded-full object-cover border-2 border-white shadow"
                            alt="Foto Profil">
                    </button>
                    <div id="settingsDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-lg py-3 hidden z-50 border border-gray-100">
                        <div class="flex flex-col items-center gap-2 p-4 pb-2 border-b border-gray-100">
                            <img src="<?= base_url('uploads/user/' . (session('user_foto') ?? 'default.png')) ?>"
                                class="w-16 h-16 rounded-full object-cover border-2 border-blue-200 shadow mb-1"
                                alt="Foto Profil">
                            <div class="font-semibold text-gray-800 text-sm"><?= esc(session('username')) ?></div>
                            <div class="text-xs text-gray-400"><?= esc(ucwords(session('role'))) ?></div>
                        </div>
                        <a href="<?= base_url('guru/profile') ?>" class="flex items-center px-5 py-2 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                            <i class="fa-solid fa-user mr-2"></i> Profile
                        </a>
                        <a href="<?= base_url('logout') ?>" class="flex items-center px-5 py-2 text-gray-700 hover:bg-gray-100 rounded-xl transition">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
