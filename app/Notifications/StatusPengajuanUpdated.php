<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusPengajuanUpdated extends Notification
{
    use Queueable;

    protected $pengajuan;
    protected $message;

    public function __construct($pengajuan, $message)
    {
        $this->pengajuan = $pengajuan;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pengajuan_id' => $this->pengajuan->id,
            'judul' => $this->pengajuan->judul,
            'status' => $this->pengajuan->status,
            'message' => $this->message,
        ];
    }
}
