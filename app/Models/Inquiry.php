<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Inquiry Model
 * 
 * Represents customer inquiries submitted through the contact form.
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $company
 * @property string $subject
 * @property string $message
 * @property int|null $product_id
 * @property string|null $product_name
 * @property string $status
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Carbon\Carbon|null $responded_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Inquiry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'product_id',
        'product_name',
        'status',
        'reference_number',
        'ip_address',
        'user_agent',
        'responded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product associated with this inquiry.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'Product_ID');
    }

    /**
     * Scope a query to only include inquiries with a specific status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include new inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope a query to only include unresolved inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnresolved($query)
    {
        return $query->whereIn('status', ['new', 'in_progress']);
    }

    /**
     * Scope a query to only include resolved inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeResolved($query)
    {
        return $query->whereIn('status', ['resolved', 'closed']);
    }

    /**
     * Scope a query to get recent inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if the inquiry is new.
     *
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    /**
     * Check if the inquiry is resolved.
     *
     * @return bool
     */
    public function isResolved(): bool
    {
        return in_array($this->status, ['resolved', 'closed']);
    }

    /**
     * Mark the inquiry as in progress.
     *
     * @return bool
     */
    public function markAsInProgress(): bool
    {
        return $this->update(['status' => 'in_progress']);
    }

    /**
     * Mark the inquiry as resolved.
     *
     * @return bool
     */
    public function markAsResolved(): bool
    {
        return $this->update([
            'status' => 'resolved',
            'responded_at' => now(),
        ]);
    }

    /**
     * Get formatted created date.
     *
     * @return string
     */
    public function getFormattedCreatedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y h:i A');
    }

    /**
     * Get validation rules for creating an inquiry.
     *
     * @return array
     */
    public static function validationRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-\.]+$/'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\d\s\-\(\)\+]+$/'],
            'company' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'product_id' => ['nullable', 'integer', 'exists:products,Product_ID'],
            'product_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
