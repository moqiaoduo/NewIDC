<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketAnswer extends Notification implements ShouldQueue
{
    use Queueable;

    private $ticket;

    private $content;

    /**
     * Create a new notification instance.
     *
     * @param Ticket $ticket
     * @param $content
     */
    public function __construct(Ticket $ticket, $content)
    {
        $this->ticket = $ticket;

        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('您在' . config('app.name') . '的工单已被回复')
            ->line('您的工单已被管理员回复')
            ->line('编号：#' . $this->ticket->id)
            ->line('标题：' . $this->ticket->title)
            ->line('内容：' . strip_tags($this->content))
            ->action('查看工单', route('ticket.show', $this->ticket))
            ->line('若该邮件与您无关，请忽略该邮件');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
