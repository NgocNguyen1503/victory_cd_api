<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    /**
     * Tên bảng.
     */
    protected $table = 'feedbacks';

    /**
     * Các thuộc tính có thể được gán giá trị hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'bill_id',
        'user_id',
        'score',
        'comment',
        'status',
    ];

    /**
     * Các thuộc tính nên được chuyển đổi sang kiểu dữ liệu cụ thể.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => 'integer',
        'score' => 'integer',
        'status' => 'integer',
    ];

    // --- RELATIONSHIPS ---

    /**
     * Lấy hóa đơn (Bill) liên quan đến phản hồi này.
     *
     * @return BelongsTo
     */
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    /**
     * Lấy người dùng (User) đã gửi phản hồi này.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}