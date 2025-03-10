<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariants;

class ProductMetaFields extends Model
{
    use HasFactory;

    protected $table = 'product_meta_fields';
    protected $primaryKey = 'id';

    public function variantProduct() {
        return $this->belongsTo(ProductVariants::class, 'variant_id', 'id');
    }
}
