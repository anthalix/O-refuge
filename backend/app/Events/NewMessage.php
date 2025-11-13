<?php

namespace App\Events;

use App\Models\Message;
use App\Models\FrontUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user;

    public function __construct(Message $message, FrontUser $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    // canal public ou privé selon ton besoin
    public function broadcastOn()
    {
        // Tu peux aussi faire un canal privé : "private-chat.{$this->user->id}"
        return new Channel('admin-channel');
    }

    public function broadcastAs()
    {
        return 'new.message';
    }
    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'content' => $this->message->content,
                'from_admin' => $this->message->from_admin, // 🔥 très important !
            ],
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'email' => $this->user->email,
            ],
        ];
    }
}
