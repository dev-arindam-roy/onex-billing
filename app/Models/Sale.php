<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;
use App\Models\User;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'id';

    public function saleProducts() {
        return $this->hasMany(SaleProduct::class, 'sale_id', 'id');
    }

    public function customerInfo() {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
}
