<?= $this->extend('siswa/layouts/main') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#6C7CF6] flex items-center gap-2">
            <i class="fa-solid fa-comments"></i> Chat dengan Guru
        </h2>
        <p class="text-sm text-gray-500">Lakukan percakapan pribadi dengan guru Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sidebar Guru -->
        <div class="bg-white rounded-2xl shadow border border-gray-200 p-4 overflow-y-auto max-h-[500px]">
            <h3 class="text-sm font-semibold text-gray-600 mb-3">Daftar Guru</h3>
            <ul class="space-y-2">
                <?php foreach ($guru as $g): ?>
                    <li>
                        <a href="<?= base_url('siswa/chat?guru=' . $g['id']) ?>"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition 
                                <?= ($selectedGuru == $g['id']) 
                                    ? 'bg-indigo-100 text-indigo-700 font-semibold' 
                                    : 'hover:bg-gray-50' ?>">
                            <div class="w-8 h-8 bg-indigo-600 text-white flex items-center justify-center rounded-full text-sm font-bold">
                                <?= strtoupper(substr($g['nama_lengkap'], 0, 1)) ?>
                            </div>
                            <span><?= esc($g['nama_lengkap']) ?></span>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>

        <!-- Chat Area -->
        <div class="md:col-span-2 bg-white rounded-2xl shadow border border-gray-200 p-4 flex flex-col h-[500px]">
            <?php if ($selectedGuru): ?>
                <div class="text-sm font-semibold text-gray-700 mb-3 border-b pb-2">
                    Chat dengan: <span class="text-indigo-600">
                        <?= esc(array_values(array_filter($guru, fn($g) => $g['id'] == $selectedGuru))[0]['nama_lengkap'] ?? '-') ?>
                    </span>
                </div>

                <!-- Chat Messages -->
                <div id="chat-box" class="flex-1 overflow-y-auto space-y-5 pr-2 bg-gray-50 rounded-xl p-4 text-sm text-gray-800"></div>

                <!-- Chat Form -->
                <form id="chat-form" class="mt-4 flex gap-3">
                    <?= csrf_field() ?>
                    <input type="hidden" name="receiver_id" value="<?= $selectedGuru ?>">
                    <input type="text" name="message" id="chat-message"
                           class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:ring-indigo-500 focus:outline-none"
                           placeholder="Ketik pesan..." required>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm transition">
                        Kirim
                    </button>
                </form>
            <?php else: ?>
                <div class="flex-1 flex items-center justify-center text-gray-400 text-center">
                    <div>
                        <i class="fa-solid fa-comment-dots text-3xl mb-2"></i><br>
                        Pilih guru dari daftar untuk memulai percakapan.
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php if ($selectedGuru): ?>
<script>
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-message');
    const guruId = <?= json_encode($selectedGuru) ?>;

    function fetchMessages() {
        fetch(`<?= base_url('siswa/chat/getMessages/') ?>${guruId}`)
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach(msg => {
                    const isSiswa = msg.role_sender === 'siswa';
                    html += `
                        <div class="flex ${isSiswa ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[75%] flex items-end gap-2">
                                ${!isSiswa ? `
                                    <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">G</div>
                                ` : ''}
                                <div class="px-4 py-2 rounded-2xl text-sm shadow 
                                    ${isSiswa 
                                        ? 'bg-indigo-600 text-white rounded-tr-none' 
                                        : 'bg-white text-gray-800 border border-indigo-100 rounded-tl-none'}">
                                    ${msg.message}
                                </div>
                                ${isSiswa ? `
                                    <div class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-bold">S</div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                });
                chatBox.innerHTML = html;
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    // Load pertama + auto refresh
    window.onload = fetchMessages;
    setInterval(fetchMessages, 3000);

    // Kirim pesan via AJAX
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = chatInput.value;

        fetch(`<?= base_url('siswa/chat/sendMessage') ?>`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: new URLSearchParams({
                receiver_id: guruId,
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
