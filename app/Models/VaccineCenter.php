<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VaccineCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'capacity_per_day',
    ];

    protected $appends = [
        'total_registered',
    ];

    /**
     * Members
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members() : HasMany
    {
        return $this->hasMany(Member::class, 'center_id');
    }

    /**
     * Total Registered
     * 
     * @return int
     */
    public function getTotalRegisteredAttribute() : int
    {
        return $this->members()->count();
    }
}
