<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Complaint extends Model
{
    use HasFactory;

    public const STATUS_MENUNGGU = 'menunggu_verifikasi';
    public const STATUS_DIVERIFIKASI = 'diverifikasi';
    public const STATUS_DIPROSES = 'sedang_diproses';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_DITOLAK = 'ditolak';

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'kecamatan',
        'desa',
        'incident_date',
        'photo_path',
        'status',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(ComplaintResponse::class)->orderBy('created_at', 'asc');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ComplaintStatusHistory::class)->orderBy('created_at', 'asc');
    }

    /**
     * Generate unique ticket number safely with database locking
     */
    public static function generateTicketNumber(): string
    {
        $year = date('Y');
        $prefix = "GL-{$year}-";

        return DB::transaction(function () use ($prefix, $year) {
            $latest = self::where('ticket_number', 'like', "{$prefix}%")
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if (! $latest) {
                return $prefix . '000001';
            }

            // Ambil nomor urut terakhir
            $parts = explode('-', $latest->ticket_number);
            $lastNumber = isset($parts[2]) ? (int) $parts[2] : 0;
            $newNumber = $lastNumber + 1;

            return $prefix . str_pad((string) $newNumber, 6, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Get label status bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU => 'Menunggu Verifikasi',
            self::STATUS_DIVERIFIKASI => 'Diverifikasi',
            self::STATUS_DIPROSES => 'Sedang Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    /**
     * Get badge color styling class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU => 'bg-amber-100 text-amber-800 border-amber-300',
            self::STATUS_DIVERIFIKASI => 'bg-sky-100 text-sky-800 border-sky-300',
            self::STATUS_DIPROSES => 'bg-blue-100 text-blue-800 border-blue-300',
            self::STATUS_SELESAI => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            self::STATUS_DITOLAK => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}

