<?php

namespace App\Notifications;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceUnsuspend extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Service
     */
    private $service;

    /**
     * Create a new notification instance.
     *
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
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
        $service = $this->service;
        [$line1, $line2] = __('service.mail.unsuspend.lines',
            ['service' => $service->product->name . ' - ' . $service->name]);
        return (new MailMessage)
            ->subject(__('service.mail.unsuspend.subject', ['website' => config('app.name')]))
            ->line($line1)
            ->action(__('service.mail.unsuspend.action'), route('service', $service))
            ->line($line2);
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
