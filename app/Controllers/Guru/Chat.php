<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\ChatModel;

class Chat extends BaseController
{
    protected $guruId;

    public function __construct()
    {
        // Ambil ID guru dari session user_id
        $guru = (new GuruModel())->where('user_id', session('user_id'))->first();
        $this->guruId = $guru['id'] ?? null;
    }

    public function index()
    {
        $siswaModel = new SiswaModel();
        $siswaList = $siswaModel->findAll();

        $siswaId = $this->request->getGet('siswa');
        $pesan = [];

        if ($siswaId && is_numeric($siswaId) && $this->guruId) {
            $chatModel = new ChatModel();

            $pesan = $chatModel
                ->groupStart()
                    ->where([
                        'sender_id'   => $this->guruId,
                        'receiver_id' => $siswaId,
                        'role_sender' => 'guru'
                    ])
                ->groupEnd()
                ->orGroupStart()
                    ->where([
                        'sender_id'   => $siswaId,
                        'receiver_id' => $this->guruId,
                        'role_sender' => 'siswa'
                    ])
                ->groupEnd()
                ->orderBy('created_at', 'ASC')
                ->findAll();

            // Tandai pesan dari siswa sebagai sudah dibaca
            $chatModel->where([
                'receiver_id' => $this->guruId,
                'sender_id'   => $siswaId,
                'role_sender' => 'siswa',
                'is_read'     => 0
            ])->set(['is_read' => 1])->update();
        }

        return view('guru/chat/index', [
            'siswa' => $siswaList,
            'selectedSiswa' => $siswaId,
            'messages' => $pesan,
            'breadcrumb' => ['Chat', 'Percakapan']
        ]);
    }

    public function sendMessage()
    {
        if (!$this->guruId) return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);

        $chatModel = new ChatModel();
        $chatModel->insert([
            'sender_id'   => $this->guruId,
            'receiver_id' => $this->request->getPost('receiver_id'),
            'role_sender' => 'guru',
            'message'     => $this->request->getPost('message'),
            'is_read'     => 0,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success']);
        }

        return redirect()->back();
    }

    public function getMessages($siswaId)
    {
        if (!$this->guruId || !is_numeric($siswaId)) {
            return $this->response->setJSON([]);
        }

        $chatModel = new ChatModel();
        $messages = $chatModel
            ->groupStart()
                ->where([
                    'sender_id'   => $this->guruId,
                    'receiver_id' => $siswaId,
                    'role_sender' => 'guru'
                ])
            ->groupEnd()
            ->orGroupStart()
                ->where([
                    'sender_id'   => $siswaId,
                    'receiver_id' => $this->guruId,
                    'role_sender' => 'siswa'
                ])
            ->groupEnd()
            ->orderBy('created_at', 'ASC')
            ->findAll();

        // Tambahkan agar bisa dibaca di JS view
        foreach ($messages as &$msg) {
            $msg['user_id'] = $msg['sender_id'];
        }

        return $this->response->setJSON($messages);
    }

    public function unreadNotif()
{
    $guru = (new \App\Models\GuruModel())->where('user_id', session('user_id'))->first();
    if (!$guru) {
        return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
    }

    $guruId = $guru['id'];
    $chatModel = new \App\Models\ChatModel();

    // FIX JOIN (dari siswa.user_id -> siswa.id)
    $pesan = $chatModel
        ->select('chat.*, siswa.nama_lengkap')
        ->join('siswa', 'siswa.id = chat.sender_id') // ✅ PERBAIKAN PENTING
        ->where('chat.receiver_id', $guruId)
        ->where('chat.role_sender', 'siswa')
        ->where('chat.is_read', 0)
        ->orderBy('chat.created_at', 'DESC')
        ->findAll();

    $result = [];
    foreach ($pesan as $p) {
        $result[] = [
            'icon'        => 'fa-solid fa-message',
            'icon_bg'     => 'bg-yellow-100',
            'icon_color'  => 'text-yellow-600',
            'title'       => esc($p['nama_lengkap']),
            'desc'        => esc($p['message']),
            'time'        => date('H:i d/m/Y', strtotime($p['created_at'])),
            'siswa_id'    => $p['sender_id'] // agar bisa klik ke chat
        ];
    }

    // SESUAII DENGAN YANG DIHARAPKAN OLEH SCRIPT
    return $this->response->setJSON([
        'pesan' => $result,
        'total' => count($result)
    ]);
}


}
