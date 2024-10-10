<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'nid',
        'birthday',
    ];

    protected $events = [
        'created' => 'scheduleVaccination',
    ];

    /**
     * Center
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */ 
    public function center() : BelongsTo
    {
        return $this->belongsTo(VaccineCenter::class);
    }

    /**
     * Schedule
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function schedule() : HasOne
    {
        return $this->hasOne(Schedule::class);
    }
}
