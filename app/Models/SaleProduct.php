<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariants;
use App\Models\Purchase;
use App\Models\Batch;
use App\Models\User;
use App\Models\Unit;
use App\Models\Sale;

class SaleProduct extends Model
{
    use HasFactory;

    protected $table = 'sale_products';
    protected $primaryKey = 'id';

    public function saleInfo() {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    public function purchaseInfo() {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function batchInfo() {
        return $this->belongsTo(Batch::class, 'batch_id', 'id');
    }

    public function vendorInfo() {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function productInfo() {
        return $this->belongsTo(ProductVariants::class, 'product_id', 'id');
    }

    public function unitInfo() {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
