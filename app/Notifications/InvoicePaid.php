<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    use Queueable;

    private $invoice_id;


    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        $url = "http://127.0.0.1:8000/InvoicesDetails/" . $this->invoice_id;
        return (new MailMessage)
                    ->subject("موقع أنس للمعلوماتية")
                    ->line('يرجى الاطلاع على معلومات الفاتورة الخاصة بكم وشكراً')
                    ->action('Notification Action', $url)
                    ->line('Thank you for Laravel 8');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
