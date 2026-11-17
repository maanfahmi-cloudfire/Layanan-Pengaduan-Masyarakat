<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'changed_by',
        'old_status',
        'new_status',
        'note',
    ];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function changer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getOldStatusLabelAttribute(): ?string
    {
        if (! $this->old_status) {
            return null;
        }

        return match ($this->old_status) {
            Complaint::STATUS_MENUNGGU => 'Menunggu Verifikasi',
            Complaint::STATUS_DIVERIFIKASI => 'Diverifikasi',
            Complaint::STATUS_DIPROSES => 'Sedang Diproses',
            Complaint::STATUS_SELESAI => 'Selesai',
            Complaint::STATUS_DITOLAK => 'Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->old_status)),
        };
    }

    public function getNewStatusLabelAttribute(): string
    {
        return match ($this->new_status) {
            Complaint::STATUS_MENUNGGU => 'Menunggu Verifikasi',
            Complaint::STATUS_DIVERIFIKASI => 'Diverifikasi',
            Complaint::STATUS_DIPROSES => 'Sedang Diproses',
            Complaint::STATUS_SELESAI => 'Selesai',
            Complaint::STATUS_DITOLAK => 'Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->new_status)),
        };
    }
}

