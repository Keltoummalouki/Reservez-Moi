<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationConfirmed extends Notification implements ShouldQueue
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
        $provider = $service->provider;
        $reservationDate = $this->reservation->reservation_date;
        
        return (new MailMessage)
            ->subject('Votre réservation a été confirmée')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre réservation pour "' . $service->name . '" a été confirmée par le prestataire.')
            ->line('Prestataire: ' . $provider->name)
            ->line('Date de réservation: ' . $reservationDate->format('d/m/Y à H:i'))
            ->line('Montant: ' . $this->reservation->amount . ' €')
            ->line('Statut du paiement: ' . ($this->reservation->payment_status === 'completed' ? 'Payé' : 'En attente de paiement'))
            ->action('Voir mes réservations', url(route('client.reservations')))
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
        $provider = $service->provider;
        
        return [
            'reservation_id' => $this->reservation->id,
            'service_id' => $service->id,
            'service_name' => $service->name,
            'provider_id' => $provider->id,
            'provider_name' => $provider->name,
            'amount' => $this->reservation->amount,
            'reservation_date' => $this->reservation->reservation_date->format('Y-m-d H:i:s'),
            'payment_status' => $this->reservation->payment_status,
            'message' => 'Votre réservation pour "' . $service->name . '" a été confirmée',
        ];
    }
}