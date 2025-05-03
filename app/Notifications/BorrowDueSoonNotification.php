<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Borrow;

class BorrowDueSoonNotification extends Notification
{
    use Queueable;

    public $borrow;

    /**
     * Create a new notification instance.
     */
    public function __construct(Borrow $borrow)
    {
        $this->borrow = $borrow;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Borrow Period Ending Soon')
                    ->line('Your borrow of "' . $this->borrow->copy->book->title . '" is due in two days.')
                    ->action('View Borrow Details', url('/borrows/' . $this->borrow->id))
                    ->line('Please return the book on time to avoid any penalties.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
