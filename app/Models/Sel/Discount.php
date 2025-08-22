<?php

namespace App\Models\Sel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $primaryKey = 'discount_id';
    protected $fillable = ['name', 'percent'];
}
