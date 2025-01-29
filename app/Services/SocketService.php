<?php

namespace App\Services;

use Pusher\Pusher;

class SocketService
{
    protected $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
    }

    public function emit($event, $data)
    {
        try {
            $this->pusher->trigger('my-channel', $event, $data);
            return true;
        } catch (\Exception $e) {
            \Log::error('Socket error: ' . $e->getMessage());
            return false;
        }
    }

    public function emitToUser($userId, $event, $data)
    {
        return $this->pusher->trigger('private-user.' . $userId, $event, $data);
    }

    public function emitToRoom($room, $event, $data)
    {
        return $this->pusher->trigger('presence-room.' . $room, $event, $data);
    }
} 