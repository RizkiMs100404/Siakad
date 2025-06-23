<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifBtn = document.getElementById('notifDropdownBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifContent = document.getElementById('notifContent');
    const notifBadge = document.getElementById('notifBadge');
    const settingsBtn = document.getElementById('settingsDropdownBtn');
    const settingsDropdown = document.getElementById('settingsDropdown');

    let notifLoaded = false;

    // ==== Dropdown Toggle ====
    notifBtn && notifBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
        settingsDropdown?.classList.add('hidden');
        if (!notifLoaded) loadNotif();
        notifBadge && (notifBadge.style.display = 'none');
    });

    settingsBtn && settingsBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        settingsDropdown.classList.toggle('hidden');
        notifDropdown?.classList.add('hidden');
    });

    document.addEventListener('click', function () {
        notifDropdown?.classList.add('hidden');
        settingsDropdown?.classList.add('hidden');
    });

    // ==== Render isi notifikasi ====
    function renderNotif(list) {
        if (!list.length) {
            notifContent.innerHTML = `<div class="px-4 py-4 text-center text-gray-400">Belum ada pesan baru.</div>`;
            return;
        }

        notifContent.innerHTML = list.map(item => `
            <div class="flex px-4 py-3 hover:bg-gray-50 rounded-xl gap-3 items-start border-b last:border-0 transition">
                <span class="flex items-center justify-center h-9 w-9 rounded-xl ${item.icon_bg}">
                    <i class="${item.icon} ${item.icon_color}"></i>
                </span>
                <div class="flex-1">
                    <div class="text-sm font-semibold text-gray-700 mb-0.5">${item.title}</div>
                    <div class="text-xs text-gray-500 mb-0.5">${item.desc}</div>
                    <div class="text-xs text-gray-400"><i class="fa-regular fa-clock"></i> ${item.time}</div>
                </div>
            </div>
        `).join('');
    }

    // ==== AJAX untuk notifikasi ====
    function loadNotif() {
        notifContent.innerHTML = `<div class="px-4 py-4 text-center text-gray-400">Memuat notifikasi...</div>`;
        fetch('<?= base_url('siswa/chat/unreadNotif') ?>')
            .then(res => res.json())
            .then(res => {
                renderNotif(res.data);
                notifBadge.innerText = res.unread;
                notifBadge.style.display = res.unread > 0 ? 'inline-block' : 'none';
                notifLoaded = true;
            }).catch(() => {
                notifContent.innerHTML = `<div class="px-4 py-4 text-center text-red-400">Gagal memuat notifikasi.</div>`;
            });
    }

    // ==== Auto refresh badge tiap 15 detik ====
    setInterval(() => {
        fetch('<?= base_url('siswa/chat/unreadNotif') ?>')
            .then(res => res.json())
            .then(res => {
                if (res.unread > 0) {
                    notifBadge.innerText = res.unread;
                    notifBadge.style.display = 'inline-block';
                } else {
                    notifBadge.style.display = 'none';
                }
            });
    }, 15000);
});
</script>


<!-- ==== Dropdown Sidebar / Sidebar Toggle ==== -->
<script>
function toggleDropdown(event, dropdownId, arrowId) {
    event.stopPropagation();
    const dropdown = document.getElementById(dropdownId);
    const arrow = document.getElementById(arrowId);
    dropdown.classList.toggle('hidden');
    arrow.classList.toggle('rotate-90');
}

document.addEventListener('DOMContentLoaded', function () {
    const isActive = document.querySelectorAll('.sidebar-sublink.bg-orange-200').length > 0;
    const dd = document.getElementById('dataMasterDropdown');
    const arrow = document.getElementById('arrowDataMaster');
    if (isActive) {
        dd.classList.remove('hidden');
        arrow.classList.add('rotate-90');
    }

    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggleBtn && sidebar) {
        sidebarToggleBtn.addEventListener('click', function () {
            sidebar.classList.remove('-translate-x-full');
        });
    }
});
</script>
