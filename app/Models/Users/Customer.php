<?php

namespace App\Models\Users;

use App\Models\Action\Order;
use App\Models\Base\Province;
use App\Models\Base\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'civility',
        'phone',
        'province_id',
        'address',
        'status_id',
        'user_id'
    ];


    protected $casts = ['birthday' => 'date'];


    public function province()
    {
        return $this->belongsTo(Province::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
         $this->belongsTo(Status::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id');
    }
}
