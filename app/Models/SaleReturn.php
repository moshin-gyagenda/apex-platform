<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'sale_item_id',
        'product_id',
        'quantity_returned',
        'unit_price',
        'refund_amount',
        'reason',
        'status',
        'processed_by',
        'processed_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'quantity_returned' => 'integer',
            'unit_price' => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'processed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the sale that owns the return.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the sale item that was returned.
     */
    public function saleItem(): BelongsTo
    {
        return $this->belongsTo(SaleItem::class);
    }

    /**
     * Get the product that was returned.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who created the return.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who processed the return.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
