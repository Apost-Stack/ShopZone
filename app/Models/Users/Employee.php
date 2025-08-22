<?php

namespace App\Models\Users;

use App\Models\Base\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;


    protected $primaryKey = 'employeeId';
    protected $fillable = ['first_name','last_name','user_id','phone','status_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
