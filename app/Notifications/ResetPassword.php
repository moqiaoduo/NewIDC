<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lang;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    protected $password;
    protected $username;

    /**
     * Create a new notification instance.
     *
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->password = $password;
        $this->username = $username;
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
            ->subject(Lang::get('Reset Password Notification'))
            ->line(Lang::get('admin.user.reset_password.line1'))
            ->line(Lang::get('admin.user.reset_password.line2', ['user' => $this->username]))
            ->line(Lang::get('admin.user.reset_password.line3', ['pass' => $this->password]))
            ->line(Lang::get('admin.user.reset_password.line4'))
            ->line(Lang::get('If you did not request a password reset, please Consult the Administrator.'));
    }
}
