<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'parent_category_id',
        'category_name',
    ];

    public function parentCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id');
    }
}
