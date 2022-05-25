<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSystemEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $type = "Mobile";
    public $phone_number;
    public $country = "Bénin";
    public $default_type;
            
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $type = null, $phone_number = null, $country)
    {
        $this->type = $type;
        $this->phone_number = $phone_number;
        $this->country = $country;
        $this->default_type = config('app.payment_type_default');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
