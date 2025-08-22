<?php

namespace App\Models\Sel\Product;

use App\Models\Action\Order;
use App\Models\Base\Status;
use App\Models\Sel\Discount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $primaryKey = 'productId';
    protected $fillable = [
        'name',
        'quantity',
        'category_id',
        'price',
        'discount_id',
        'available_at',
        'status_id',
        'slug',
        'weight',
        'height'
    ];


    protected $casts = [
        'available_at' => 'datetime',
    ];


    public function category()
    {
    return $this->belongsTo(Category::class);
    }


    public function discount()
    {
    return $this->belongsTo(Discount::class);
    }


    public function images()
    {
    return $this->hasMany(ProductImage::class);
    }


    public function status()
    {
    return $this->belongsTo(Status::class);
    }


    public function orders()
    {
    return $this->belongsToMany(Order::class)
    ->withPivot(['quantity','unit_price','discount_percent'])
    ->withTimestamps();
    }
}
