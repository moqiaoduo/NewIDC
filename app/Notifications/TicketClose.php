<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketClose extends Notification implements ShouldQueue
{
    use Queueable;

    private $ticket;

    /**
     * Create a new notification instance.
     *
     * @param Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('您在' . config('app.name') . '的工单已被关闭')
            ->line('由于您超过48小时未响应或管理员操作，您的工单已被关闭')
            ->line('编号：#' . $this->ticket->id)
            ->line('标题：' . $this->ticket->title)
            ->line('若您仍对该工单有问题，请直接回复工单来重新打开工单')
            ->action('查看工单', route('ticket.show', $this->ticket))
            ->line('若该邮件与您无关，请忽略该邮件');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
