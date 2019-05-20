<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Workshop
 * @package App\Models
 */
class Workshop extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time', 'max_guests',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
