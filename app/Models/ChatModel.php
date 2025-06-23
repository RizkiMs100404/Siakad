<?php

namespace App\Models;
use CodeIgniter\Model;

class ChatModel extends Model {
    protected $table = 'chat';
    protected $allowedFields = ['sender_id', 'receiver_id', 'role_sender', 'message', 'is_read'];
    protected $useTimestamps = true;
}
