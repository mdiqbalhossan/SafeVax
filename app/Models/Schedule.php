<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'vaccine_center_id',
        'date',
    ];

    /**
     * Member
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member() : BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Vaccine Center
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vaccineCenter() : BelongsTo
    {
        return $this->belongsTo(VaccineCenter::class);
    }
}
