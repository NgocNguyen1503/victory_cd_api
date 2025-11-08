<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    // Sử dụng trait SoftDeletes vì bảng có cột 'deleted_at'
    use HasFactory, SoftDeletes;

    /**
     * Tên bảng nếu khác với tên số nhiều mặc định của model.
     * protected $table = 'products';
     */

    /**
     * Các thuộc tính có thể được gán giá trị hàng loạt (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'thumbnail_url',
        'audio_url',
        'brand',
        'price',
        'quantity',
        'score',
    ];

    /**
     * Các thuộc tính nên được chuyển đổi sang kiểu dữ liệu cụ thể khi truy vấn (Casting).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'score' => 'float',
        'quantity' => 'integer',
        'deleted_at' => 'datetime',
    ];

    // --- RELATIONSHIPS ---

    /**
     * Lấy danh mục (Category) mà sản phẩm này thuộc về.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        // Liên kết bằng khóa ngoại 'category_id'
        return $this->belongsTo(Category::class);
    }
}