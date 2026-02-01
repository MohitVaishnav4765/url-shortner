<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type,$user,$company,$password;
    /**
     * Create a new event instance.
     */
    public function __construct($type,$user,$company,$password = '')
    {
        $this->type = $type;
        $this->user = $user;
        $this->company = $company;
        $this->password = $password;
    }
}
