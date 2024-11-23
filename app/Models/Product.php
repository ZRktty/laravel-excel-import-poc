<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Categories\Traits\Categorizable;

class Product extends Model
{
    use Categorizable;

    /** The attributes that should be handled as date or datetime.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];


    protected $fillable = [
        'name',
        'description',
        'price',
        'brand_id',
        'category_id',
        'packaging',
        'ean',
        'on_sale',
        'is_active',
    ];

    protected $casts = [
        'og_data'   => 'array',
        'meta_data' => 'array',
        'is_active' => 'boolean',
        'on_sale' => 'boolean',
    ];


    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
