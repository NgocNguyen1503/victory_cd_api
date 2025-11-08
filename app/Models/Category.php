<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // Use the SoftDeletes trait because the table includes a 'deleted_at' column
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'parent_id',
        'thumbnail_url',
    ];

    /**
     * Get the parent category that owns the Category.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        // A category belongs to one parent (which is also a Category)
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child category for the Category.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        // A category can have many child category
        return $this->hasMany(Category::class, 'parent_id');
    }
}