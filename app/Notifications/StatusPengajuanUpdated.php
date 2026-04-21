<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusPengajuanUpdated extends Notification
{
    use Queueable;

    protected $item;
    protected $message;

    public function __construct($item, $message)
    {
        $this->item = $item;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        // Deteksi tipe model untuk menentukan judul/ID
        $type = ($this->item instanceof \App\Models\RKAS) ? 'RKAS' : 'Pengajuan';
        $title = ($this->item instanceof \App\Models\RKAS) 
                    ? 'RKAS ' . $this->item->tahun_ajaran 
                    : $this->item->judul;

        return [
            'item_id' => $this->item->id,
            'type' => $type,
            'title' => $title,
            'status' => $this->item->status,
            'message' => $this->message,
        ];
    }
}
