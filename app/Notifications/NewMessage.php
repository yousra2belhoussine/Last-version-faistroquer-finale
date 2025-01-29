<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The message instance.
     *
     * @var \App\Models\Message
     */
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $proposition = $this->message->proposition;
        $sender = $this->message->user;

        return (new MailMessage)
            ->subject(__('New Message from :name', ['name' => $sender->name]))
            ->line(__('You have received a new message regarding the exchange proposition for ":ad"', [
                'ad' => $proposition->ad->title
            ]))
            ->line($this->message->content)
            ->action(__('View Message'), route('propositions.show', $proposition))
            ->line(__('Thank you for using our platform!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'proposition_id' => $this->message->proposition_id,
            'sender_id' => $this->message->user_id,
            'sender_name' => $this->message->user->name,
            'content' => $this->message->content,
        ];
    }
} 