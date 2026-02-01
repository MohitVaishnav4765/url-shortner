<?php

namespace App\Listeners;

use App\Events\SendMailEvent;
use App\Notifications\UserNotification;

class SendMailListener
{

    const INVITE_NEW_COMPANY_ADMIN = 'INVITE_COMPANY_ADMIN';
    const INVITE_EXISTING_COMPANY_ADMIN = 'INVITE_EXISTING_COMPANY_ADMIN';
    const INVITE_COMPANY_MEMBER = 'INVITE_COMPANY_MEMBER';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendMailEvent $event): void
    {
        if(filled($event->user ?? null)){
            $event->user->notify(new UserNotification($event->type,$event->user,$event->company,$event->password));
        }
    }
}
