<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'created' => 'App\Listeners\ScheduleVaccination',
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
}
