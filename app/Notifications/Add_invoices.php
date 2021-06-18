<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\invoices;
use Illuminate\Support\Facades\Auth;

class Add_invoices extends Notification
{
    use Queueable;
    private $invoices;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoices1)
    {
        $this->invoices = $invoices1;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         //
    //     ];
    // }
   
    public function toDatabase($notifiable)
    {
        return [

            //'data' => $this->details['body']
            'title'=>'تم اضافة فاتورة جديدة برقم :',
            'invouce_number'=> $this->invoices-> invoice_number,
            'by'=>'بواسطة',
            'id'=> $this->invoices->id,
            'user'=> Auth::user()->name,
        ];
    }

}
