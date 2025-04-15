<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $service = $this->reservation->service;
        $client = $this->reservation->user;
        
        return (new MailMessage)
            ->subject('Nouvelle réservation')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle réservation a été effectuée pour votre service "' . $service->name . '".')
            ->line('Client: ' . $client->name)
            ->line('Date de réservation: ' . $this->reservation->reservation_date->format('d/m/Y à H:i'))
            ->line('Statut: En attente de confirmation')
            ->action('Gérer cette réservation', url(route('provider.reservations')))
            ->line('Merci d\'utiliser Reservez-moi!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $service = $this->reservation->service;
        $client = $this->reservation->user;
        
        return [
            'reservation_id' => $this->reservation->id,
            'service_id' => $service->id,
            'service_name' => $service->name,
            'client_id' => $client->id,
            'client_name' => $client->name,
            'reservation_date' => $this->reservation->reservation_date->format('Y-m-d H:i:s'),
            'message' => 'Nouvelle réservation pour "' . $service->name . '" par ' . $client->name,
        ];
    }
}