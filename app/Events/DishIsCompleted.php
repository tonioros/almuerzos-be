<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class DishIsCompleted extends Notification
{

    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
            title: $this->order->name . ' is ready',
            body: 'Your ' . $this->order->name . ' has been completed.',
        )))->data(['order' => $this->order]);
    }
}
