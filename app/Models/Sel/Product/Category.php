<?php

namespace App\Models\Sel\Product;

use App\Models\Base\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $primaryKey = 'categoryId';
    protected $fillable = ['name', 'picture', 'status_id'];


    public function status()
    {
    return $this->belongsTo(Status::class);
    }


    public function products()
    {
    return $this->hasMany(Product::class);
    }
}
