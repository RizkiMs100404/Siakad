<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-[#6C7CF6] mb-6 flex items-center gap-2">
    <i class="fa-solid fa-comments"></i> Chat dengan Siswa
</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Sidebar Siswa -->
    <div class="bg-white shadow rounded-2xl p-4 overflow-y-auto max-h-[500px] border border-gray-200">
        <h3 class="font-semibold text-gray-700 mb-3">Daftar Siswa</h3>
        <ul class="space-y-2">
            <?php foreach ($siswa as $s): ?>
                <li>
                    <a href="<?= base_url('guru/chat?siswa=' . $s['id']) ?>"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg 
                            <?= ($selectedSiswa == $s['id']) ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-gray-100' ?>">
                        <div class="w-8 h-8 bg-indigo-500 text-white flex items-center justify-center rounded-full text-sm font-bold">
                            <?= strtoupper(substr($s['nama_lengkap'], 0, 1)) ?>
                        </div>
                        <span><?= esc($s['nama_lengkap']) ?></span>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>

    <!-- Chat Box -->
    <div class="md:col-span-2 bg-white shadow rounded-2xl p-4 flex flex-col h-[500px] border border-gray-200">
        <?php if ($selectedSiswa): ?>
            <div class="font-semibold text-gray-700 mb-3 border-b pb-2">
                Chat dengan: <span class="text-indigo-600">
                    <?= esc(array_values(array_filter($siswa, fn($s) => $s['id'] == $selectedSiswa))[0]['nama_lengkap'] ?? '-') ?>
                </span>
            </div>

            <!-- Chat Messages -->
            <div id="chat-box" class="flex-1 overflow-y-auto space-y-5 pr-2 bg-gray-50 rounded-xl p-4 text-sm text-gray-800"></div>

            <!-- Chat Form -->
            <form id="chat-form" class="mt-4 flex gap-3">
                <?= csrf_field() ?>
                <input type="hidden" name="receiver_id" value="<?= $selectedSiswa ?>">
                <input type="text" name="message" id="chat-message"
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:ring-indigo-500 focus:outline-none"
                    placeholder="Ketik pesan..." required>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm">
                    Kirim
                </button>
            </form>
        <?php else: ?>
            <div class="flex-1 flex items-center justify-center text-gray-400 text-center">
                <div>
                    <i class="fa-solid fa-comment-dots text-3xl mb-2"></i><br>
                    Pilih siswa untuk memulai percakapan.
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<?php if ($selectedSiswa): ?>
<script>
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-message');
    const siswaId = <?= json_encode($selectedSiswa) ?>;

    function fetchMessages() {
        fetch(`<?= base_url('guru/chat/getMessages/') ?>${siswaId}`)
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach(msg => {
                    const isGuru = msg.role_sender === 'guru';
                    html += `
                        <div class="flex ${isGuru ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[75%] flex items-end gap-2">
                                ${!isGuru ? `
                                    <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">S</div>
                                ` : ''}
                                <div class="px-4 py-2 rounded-2xl text-sm shadow 
                                    ${isGuru 
                                        ? 'bg-indigo-600 text-white rounded-tr-none' 
                                        : 'bg-white text-gray-800 border border-indigo-100 rounded-tl-none'}">
                                    ${msg.message}
                                </div>
                                ${isGuru ? `
                                    <div class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-bold">G</div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                });
                chatBox.innerHTML = html;
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    // Load awal + polling
    window.onload = fetchMessages;
    setInterval(fetchMessages, 3000);

    // Kirim pesan AJAX
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = chatInput.value;

        fetch(`<?= base_url('guru/chat/sendMessage') ?>`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: new URLSearchParams({
                receiver_id: siswaId,
                message: message
            })
        }).then(res => res.json())
          .then(() => {
              chatInput.value = '';
              fetchMessages();
          });
    });
</script>
<?php endif ?>

<?= $this->endSection() ?>
