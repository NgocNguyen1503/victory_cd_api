<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể được gán giá trị hàng loạt (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_code',
        'total_price',
        'status',
        'payment_method',
        'phone',
        'address',
    ];

    /**
     * Các thuộc tính nên được chuyển đổi sang kiểu dữ liệu cụ thể (Casting).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'float',
        'order_code' => 'integer',
        'status' => 'integer',
        'payment_method' => 'integer',
    ];

    // --- RELATIONSHIPS ---

    /**
     * Lấy người dùng (User) đã tạo hóa đơn này.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy chi tiết (BillDetails) của hóa đơn này.
     *
     * @return HasMany
     */
    public function details(): HasMany
    {
        // Khóa ngoại: bill_id
        return $this->hasMany(BillDetail::class);
    }

    /**
     * Lấy phản hồi (Feedback) liên quan đến hóa đơn này.
     *
     * @return HasMany
     */
    public function feedbacks(): HasMany
    {
        // Khóa ngoại: bill_id
        return $this->hasMany(Feedback::class);
    }
}