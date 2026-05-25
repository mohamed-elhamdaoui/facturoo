<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    // Only created_at, no updated_at
    public $timestamps = false;
    public $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'reason',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
