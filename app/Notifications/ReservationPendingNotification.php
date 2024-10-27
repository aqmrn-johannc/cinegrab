<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationPendingNotification extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'user_name' => $this->reservation->user->name,
            'movie_title' => $this->reservation->movie->title,
            'seat_number' => $this->reservation->seat_number,
            'message' => 'User ' . $this->reservation->user->name . ' booked ' . $this->reservation->movie->title .
                         ' with the seat number ' . $this->reservation->seat_number . ', and is awaiting approval.'
        ];
    }
}
