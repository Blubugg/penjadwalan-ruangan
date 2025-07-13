<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminActionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $status;
    protected $jadwal;

    public function __construct($status, $jadwal)
    {
        $this->status = $status;
        $this->jadwal = $jadwal;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Status Jadwal Anda Telah ' . $this->status)
                ->view('emails.admin_action', [
                    'user' => $notifiable,
                    'status' => $this->status,
                    'jadwal' => $this->jadwal
                ]);
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
