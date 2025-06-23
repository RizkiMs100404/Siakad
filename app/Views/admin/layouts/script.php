<script>
document.addEventListener('DOMContentLoaded', function () {
    // Notif Dropdown
    const notifBtn = document.getElementById('notifDropdownBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifContent = document.getElementById('notifContent');
    const notifBadge = document.getElementById('notifBadge');
    const settingsBtn = document.getElementById('settingsDropdownBtn');
    const settingsDropdown = document.getElementById('settingsDropdown');

    let notifLoaded = false;

    // Notifikasi event
    notifBtn && notifBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
        settingsDropdown && settingsDropdown.classList.add('hidden');
        if (!notifLoaded) loadNotif();
        // Hilangkan badge saat klik bell
        if (notifBadge) notifBadge.style.display = 'none';
    });

    // Settings event
    settingsBtn && settingsBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        settingsDropdown.classList.toggle('hidden');
        notifDropdown && notifDropdown.classList.add('hidden');
    });

    // Close semua dropdown saat klik luar
    document.addEventListener('click', function(e) {
        notifDropdown && notifDropdown.classList.add('hidden');
        settingsDropdown && settingsDropdown.classList.add('hidden');
    });

    function renderNotif(list) {
        if (!list.length) {
            notifContent.innerHTML = `<div class="px-4 py-4 text-center text-gray-400">Belum ada notifikasi.</div>`;
            return;
        }
        notifContent.innerHTML = list.map(item => `
            <div class="flex px-4 py-3 hover:bg-gray-50 rounded-xl gap-2 items-start border-b last:border-0">
                <span class="flex items-center justify-center h-9 w-9 rounded-xl ${item.icon_bg}">
                    <i class="${item.icon} ${item.icon_color}"></i>
                </span>
                <div class="flex-1">
                    <div class="text-sm font-semibold text-gray-700 mb-0.5">${item.title}</div>
                    <div class="text-xs text-gray-400 mb-0.5">${item.desc}</div>
                    <div class="text-xs text-gray-300"><i class="fa-regular fa-clock"></i> ${item.time}</div>
                </div>
            </div>
        `).join('');
    }

    // AJAX load notif
    function loadNotif() {
        notifContent.innerHTML = `<div class="px-4 py-4 text-center text-gray-400">Memuat notifikasi...</div>`;
        fetch('<?= base_url('admin/notifikasi/datamaster') ?>')
            .then(res => res.json())
            .then(res => {
                renderNotif(res.data);
                // Badge hanya diupdate di loadNotif, tapi langsung hilang saat bell di klik
                notifBadge.innerText = res.unread;
                notifBadge.style.display = res.unread > 0 ? 'inline-block' : 'none';
                notifLoaded = true;
            }).catch(() => {
                notifContent.innerHTML = `<div class="px-4 py-4 text-center text-red-400">Gagal memuat notifikasi.</div>`;
            });
    }
});
</script>



<script>
    // Dropdown toggle
    function toggleDropdown(event, dropdownId, arrowId) {
        event.stopPropagation();
        const dropdown = document.getElementById(dropdownId);
        const arrow = document.getElementById(arrowId);
        dropdown.classList.toggle('hidden');
        arrow.classList.toggle('rotate-90');
    }
    // Auto open dropdown if active
    document.addEventListener('DOMContentLoaded', function () {
        const dataMasterActive = document.querySelectorAll('.sidebar-sublink.bg-orange-200').length > 0;
        const dd = document.getElementById('dataMasterDropdown');
        const arrow = document.getElementById('arrowDataMaster');
        if (dataMasterActive) {
            dd.classList.remove('hidden');
            arrow.classList.add('rotate-90');
        }
    });
</script>

<!-- ==== Tambah script sidebar mobile di bawah ini ==== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebar = document.getElementById('sidebar');
        if(sidebarToggleBtn && sidebar){
            sidebarToggleBtn.addEventListener('click', function() {
                sidebar.classList.remove('-translate-x-full');
            });
        }
    });
</script>
