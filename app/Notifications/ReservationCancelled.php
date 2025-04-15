<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservation;
    protected $cancelledBy;

    /**
     * Create a new notification instance.
     *
     * @param Reservation $reservation
     * @param string $cancelledBy 'provider' or 'client'
     * @return void
     */
    public function __construct(Reservation $reservation, $cancelledBy)
    {
        $this->reservation = $reservation;
        $this->cancelledBy = $cancelledBy;
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
        $canceller = $this->cancelledBy === 'provider' ? $service->provider->name : $this->reservation->user->name;
        
        $title = 'Votre réservation a été annulée';
        if ($this->cancelledBy === 'provider' && $notifiable->id === $this->reservation->user_id) {
            $message = 'Votre réservation pour "' . $service->name . '" a été annulée par le prestataire.';
            $routeName = 'client.reservations';
        } elseif ($this->cancelledBy === 'client' && $notifiable->id === $service->provider_id) {
            $title = 'Une réservation a été annulée';
            $message = 'La réservation pour "' . $service->name . '" a été annulée par le client.';
            $routeName = 'provider.reservations';
        } else {
            $message = 'La réservation pour "' . $service->name . '" a été annulée.';
            $routeName = $notifiable->roles()->where('name', 'ServiceProvider')->exists() 
                ? 'provider.reservations' 
                : 'client.reservations';
        }
        
        return (new MailMessage)
            ->subject($title)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line($message)
            ->line('Service: ' . $service->name)
            ->line('Date prévue: ' . $this->reservation->reservation_date->format('d/m/Y à H:i'))
            ->action('Voir les réservations', url(route($routeName)))
            ->line('Si vous avez des questions, n\'hésitez pas à nous contacter.')
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
        $canceller = $this->cancelledBy === 'provider' ? $service->provider->name : $this->reservation->user->name;
        
        return [
            'reservation_id' => $this->reservation->id,
            'service_id' => $service->id,
            'service_name' => $service->name,
            'reservation_date' => $this->reservation->reservation_date->format('Y-m-d H:i:s'),
            'cancelled_by' => $this->cancelledBy,
            'canceller_name' => $canceller,
            'message' => 'La réservation pour "' . $service->name . '" a été annulée par ' . ($this->cancelledBy === 'provider' ? 'le prestataire.' : 'le client.'),
        ];
    }
}