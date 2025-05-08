<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'reservation_date',
        'status',
        'notes',
        'amount',
        'payment_status',
        'paypal_transaction_id',
        'paypal_order_id',
        'cancelled_at',
        'cancelled_reason',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Les statuts de réservation possibles
     */
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    /**
     * Les statuts de paiement possibles
     */
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_COMPLETED = 'completed';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';

    /**
     * Relation avec l'utilisateur (client)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relation avec le prestataire de service
     */
    public function provider()
    {
        return $this->hasOneThrough(User::class, Service::class, 'id', 'id', 'service_id', 'provider_id');
    }

    /**
     * Vérifier si la réservation peut être annulée
     * 
     * @return bool
     */
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    /**
     * Vérifier si la réservation peut être confirmée
     * 
     * @return bool
     */
    public function canBeConfirmed()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Vérifier si la réservation est en attente de paiement
     * 
     * @return bool
     */
    public function isPendingPayment()
    {
        return $this->payment_status === self::PAYMENT_PENDING;
    }

    /**
     * Vérifier si la réservation a été payée
     * 
     * @return bool
     */
    public function isPaid()
    {
        return $this->payment_status === self::PAYMENT_COMPLETED;
    }

    /**
     * Marquer la réservation comme annulée
     * 
     * @param string|null $reason
     * @return bool
     */
    public function markAsCancelled($reason = null)
    {
        if (!$this->canBeCancelled()) {
            return false;
        }
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'cancelled_reason' => $reason,
        ]);
        return true;
    }

    /**
     * Marquer la réservation comme confirmée
     * 
     * @return bool
     */
    public function markAsConfirmed()
    {
        if (!$this->canBeConfirmed()) {
            return false;
        }
        $this->update([
            'status' => self::STATUS_CONFIRMED,
        ]);
        return true;
    }

    /**
     * Marquer la réservation comme payée
     * 
     * @param string|null $transactionId
     * @return bool
     */
    public function markAsPaid($transactionId = null)
    {
        if ($this->payment_status === self::PAYMENT_COMPLETED) {
            return false;
        }
        $data = [
            'payment_status' => self::PAYMENT_COMPLETED,
        ];
        if ($transactionId) {
            $data['paypal_transaction_id'] = $transactionId;
        }
        if ($this->status === self::STATUS_PENDING) {
            $data['status'] = self::STATUS_CONFIRMED;
        }
        $this->update($data);
        return true;
    }

    /**
     * Scope: réservations actives (pas annulées)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', self::STATUS_CANCELLED);
    }

    /**
     * Scope: réservations payées
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_COMPLETED);
    }

    /**
     * Scope: réservations à venir
     */
    public function scopeUpcoming($query)
    {
        return $query->where('reservation_date', '>=', now())
                    ->where('status', '!=', self::STATUS_CANCELLED);
    }

    /**
     * Scope: réservations passées
     */
    public function scopePast($query)
    {
        return $query->where('reservation_date', '<', now());
    }

    /**
     * Scope: par statut
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}