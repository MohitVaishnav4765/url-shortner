<?php

namespace App\Notifications;

use App\Listeners\SendMailListener;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $type,$user,$company,$password;
    /**
     * Create a new notification instance.
     */
    public function __construct($type,$user,$company,$password = '')
    {
        $this->type = $type;
        $this->user = $user;
        $this->company = $company;
        $this->password = $password;
        $this->onQueue('user_email_notification');
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
    public function toMail(object $notifiable): MailMessage
    {

        $subject = '';
        $view = '';
        $data = [];
        switch($this->type){
            case SendMailListener::INVITE_NEW_COMPANY_ADMIN:
                $subject = 'You are invited as admin';
                $view = 'emails.invite_new_admin';
                $data = [
                    'user_name' => $this->user->name,
                    'company_name' => $this->company->name,
                    'user_email' => $this->user->email,
                    'password' => $this->password
                ];
                break;
            case SendMailListener::INVITE_EXISTING_COMPANY_ADMIN:
                $subject = 'You are invited to be an admin for a new company';
                $view = 'emails.invite_existing_admin';
                $data = [
                    'user_name' => $this->user->name,
                    'company_name' => $this->company->name,
                ];
                break;
            case SendMailListener::INVITE_COMPANY_MEMBER:
                $subject = 'Your are invited to be a member of a company';
                $view = 'emails.invite_member';
                $data = [
                    'user_name' => $this->user->name,
                    'company_name' => $this->company->name,
                    'user_email' => $this->user->email,
                    'password' => $this->password
                ];
        };


        return (new MailMessage)
            ->subject($subject)
            ->view($view,$data);
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
