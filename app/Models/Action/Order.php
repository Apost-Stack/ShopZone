<?php

namespace App\Models\Action;

use App\Enums\OrderStatusEnum;
use App\Enums\PayementMethodEnum;
use App\Models\Sel\Discount;
use App\Models\Sel\Product\Product;
use App\Models\Users\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $primaryKey = 'orderId';


    protected $fillable = [
        'reference','delivery_id','customer_id','order_status','status_id','payment_method','discount_id','total_product','price_total','tax','cash_paid','label_url'
    ];


    protected $casts = [
        'order_status' => OrderStatusEnum::class,
        'payment_method' => PayementMethodEnum::class,
    ];


    public function delivery()
    {
    return $this->belongsTo(Delivery::class);
    }


    public function customer()
    {
    return $this->belongsTo(Customer::class,'customer_id');
    }


    public function discount()
    {
    return $this->belongsTo(Discount::class);
    }


    public function products()
    {
    return $this->belongsToMany(Product::class,'order_product')
        ->withPivot(['quantity','unit_price','discount_percent'])
        ->withTimestamps();
    }
}
