<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\ChatModel;

class Chat extends BaseController
{
    protected $siswaId;

    public function __construct()
    {
        // Ambil ID siswa dari session user_id
        $siswa = (new SiswaModel())->where('user_id', session('user_id'))->first();
        $this->siswaId = $siswa['id'] ?? null;
    }

    public function index()
    {
        $guruModel = new GuruModel();
        $guruList = $guruModel->findAll();

        $guruId = $this->request->getGet('guru');
        $pesan = [];

        if ($guruId && is_numeric($guruId) && $this->siswaId) {
            $chatModel = new ChatModel();

            $pesan = $chatModel
                ->groupStart()
                    ->where([
                        'sender_id'   => $this->siswaId,
                        'receiver_id' => $guruId,
                        'role_sender' => 'siswa'
                    ])
                ->groupEnd()
                ->orGroupStart()
                    ->where([
                        'sender_id'   => $guruId,
                        'receiver_id' => $this->siswaId,
                        'role_sender' => 'guru'
                    ])
                ->groupEnd()
                ->orderBy('created_at', 'ASC')
                ->findAll();

            // Tandai pesan dari guru sebagai sudah dibaca
            $chatModel->where([
                'receiver_id' => $this->siswaId,
                'sender_id'   => $guruId,
                'role_sender' => 'guru',
                'is_read'     => 0
            ])->set(['is_read' => 1])->update();
        }

        return view('siswa/chat/index', [
            'guru' => $guruList,
            'selectedGuru' => $guruId,
            'messages' => $pesan,
            'breadcrumb' => ['Chat', 'Percakapan']
        ]);
    }

    public function sendMessage()
    {
        if (!$this->siswaId) return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);

        $chatModel = new ChatModel();
        $chatModel->insert([
            'sender_id'   => $this->siswaId,
            'receiver_id' => $this->request->getPost('receiver_id'),
            'role_sender' => 'siswa',
            'message'     => $this->request->getPost('message'),
            'is_read'     => 0,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success']);
        }

        return redirect()->back();
    }

    public function getMessages($guruId)
    {
        if (!$this->siswaId || !is_numeric($guruId)) {
            return $this->response->setJSON([]);
        }

        $chatModel = new ChatModel();
        $messages = $chatModel
            ->groupStart()
                ->where([
                    'sender_id'   => $this->siswaId,
                    'receiver_id' => $guruId,
                    'role_sender' => 'siswa'
                ])
            ->groupEnd()
            ->orGroupStart()
                ->where([
                    'sender_id'   => $guruId,
                    'receiver_id' => $this->siswaId,
                    'role_sender' => 'guru'
                ])
            ->groupEnd()
            ->orderBy('created_at', 'ASC')
            ->findAll();

        // Tambahkan user_id agar bisa dipakai di view
        foreach ($messages as &$msg) {
            $msg['user_id'] = $msg['sender_id'];
        }

        return $this->response->setJSON($messages);
    }

    public function checkNewMessages()
    {
        if (!$this->siswaId) return $this->response->setJSON(['unread' => 0]);

        $chatModel = new ChatModel();
        $unread = $chatModel
            ->where('receiver_id', $this->siswaId)
            ->where('role_sender', 'guru')
            ->where('is_read', 0)
            ->countAllResults();

        return $this->response->setJSON(['unread' => $unread]);
    }

    public function unreadNotif()
    {
        if (!$this->siswaId) return $this->response->setJSON(['unread' => 0, 'data' => []]);

        $chatModel = new ChatModel();
        $pesan = $chatModel
            ->select('chat.*, guru.nama_lengkap')
            ->join('guru', 'guru.id = chat.sender_id')
            ->where('chat.receiver_id', $this->siswaId)
            ->where('chat.role_sender', 'guru')
            ->where('chat.is_read', 0)
            ->orderBy('chat.created_at', 'DESC')
            ->findAll();

        $result = [];
        foreach ($pesan as $p) {
            $result[] = [
                'icon'        => 'fa-solid fa-message',
                'icon_bg'     => 'bg-green-100',
                'icon_color'  => 'text-green-600',
                'title'       => esc($p['nama_lengkap']),
                'desc'        => esc($p['message']),
                'time'        => date('H:i d/m/Y', strtotime($p['created_at']))
            ];
        }

        return $this->response->setJSON([
            'unread' => count($result),
            'data'   => $result
        ]);
    }
}
