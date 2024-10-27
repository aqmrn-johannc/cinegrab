<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ReservationStatusChanged extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct(Model $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->reservation_id,
            'status' => $this->reservation->status,
            'movie_title' => $this->reservation->movie->title,
            'seat_number' => $this->reservation->seat_number,
        ];
    }
}
