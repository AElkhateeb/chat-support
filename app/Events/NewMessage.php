<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer_id;
    public $customer_type;
    public $customer_name;
    public $phone;
    public $body;
    public $dir;
    public $sender_id;
    public $sender_type;
    public $sender_name;
    public $img;
    public $chat_id;
    public $date;
    public $time;

    /**
     * 
     *
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $sender=str_replace('App\Models\Users\\','',$data['sender_type']);
                $role=str_replace('Brackets\AdminAuth\Models\\','',$sender);

        $this->customer_id = $data['customer_id'];
        $this->customer_type = $data['customer_type'];
        $this->customer_name = $data['customer_name'];
        $this->phone = $data['phone'];
        $this->body = $data['body'];
        $this->dir = $data['dir'];
        $this->sender_id = $data['sender_id'];
        $this->sender_type = $role;
        $this->sender_name = $data['sender_name'];
        $this->img = $data['img'];
        $this->chat_id = $data['chat_id'];
        //$this->created_at = date("Y-m-d h:i A", strtotime(Carbon::now()));
        //
        $this->date = date("Y-m-d", strtotime(Carbon::now()));
        $this->time = date("h:i A", strtotime(Carbon::now()));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
       return new channel('support-chat-718');
      //  return ['support-chat-718'];
    }

}
