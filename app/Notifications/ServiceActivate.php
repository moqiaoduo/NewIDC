<?php

namespace App\Notifications;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceActivate extends Notification implements ShouldQueue
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
        // TODO: 插件自定义邮件模板
        [$line1, $line2, $line3, $line4, $line5] = __('service.mail.activate.lines',
            ['website' => config('app.name'),
                'username' => $service->username,
                'password' => $service->password,
                'domain' => $service->domain,
                'service' => $service->product->name . ' - ' . $service->name]);
        return (new MailMessage)
            ->subject(__('service.mail.activate.subject', ['website' => config('app.name')]))
            ->line($line1)
            ->line($line2)
            ->line($line3)
            ->line($line4)
            ->action(__('service.mail.activate.action'), route('service', $service))
            ->line($line5);
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
