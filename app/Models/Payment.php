<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Database\Factories\PaymentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $order_id
 * @property float $amount
 * @property PaymentMethod $method
 * @property PaymentStatus $status
 * @property string|null $reference
 * @property array<string, mixed>|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Order|null $order
 *
 * @method static PaymentFactory factory($count = null, $state = [])
 * @method static Builder<static>|Payment newModelQuery()
 * @method static Builder<static>|Payment newQuery()
 * @method static Builder<static>|Payment query()
 * @method static Builder<static>|Payment whereAmount($value)
 * @method static Builder<static>|Payment whereCreatedAt($value)
 * @method static Builder<static>|Payment whereDeletedAt($value)
 * @method static Builder<static>|Payment whereId($value)
 * @method static Builder<static>|Payment whereMethod($value)
 * @method static Builder<static>|Payment whereMeta($value)
 * @method static Builder<static>|Payment whereOrderId($value)
 * @method static Builder<static>|Payment whereReference($value)
 * @method static Builder<static>|Payment whereStatus($value)
 * @method static Builder<static>|Payment whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'status',
        'reference',
        'meta',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => MoneyCast::class,
        'method' => PaymentMethod::class,
        'status' => PaymentStatus::class,
        'meta' => 'array',
    ];

    /** @return BelongsTo<Order,$this> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
