<?php

namespace Mobiverse\AppsnmobilePayment\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Mobiverse\AppsnmobilePayment\Models\MomoTransaction;

class PaymentFailed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public MomoTransaction $momoTransaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MomoTransaction $momoTransaction)
    {
        $this->momoTransaction = $momoTransaction;
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
