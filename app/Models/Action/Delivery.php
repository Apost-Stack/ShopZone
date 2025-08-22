<?php

namespace App\Models\Action;

use App\Models\Base\Province;
use App\Models\Base\Status;
use App\Models\Sel\Discount;
use App\Models\Users\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;


    protected $primaryKey = 'deliveryId';
    protected $fillable = [
    'name','province_id','address','user_id','description','cost','status_id','employee_id','discount_id'
    ];


    public function province()
    {
    return $this->belongsTo(Province::class);
    }


    public function status()
    {
    return $this->belongsTo(Status::class);
    }


    public function employee()
    {
    return $this->belongsTo(Employee::class);
    }


    public function discount()
    {
    return $this->belongsTo(Discount::class);
    }
}
