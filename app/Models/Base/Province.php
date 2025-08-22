<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status_id',
    ];

    /**
     * Get the status associated with the province.
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
