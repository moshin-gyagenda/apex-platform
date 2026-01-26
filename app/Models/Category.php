<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get sub-categories (if you have a sub_categories table with parent_id)
     * For now, this returns empty collection since we don't have sub-categories table
     */
    public function subCategories()
    {
        // If you have a sub_categories table, uncomment and use:
        // return $this->hasMany(SubCategory::class, 'parent_id');
        
        // For now, return empty collection
        return $this->hasMany(Category::class, 'parent_id');
    }
}
