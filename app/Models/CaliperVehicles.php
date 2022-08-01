<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaliperVehicles extends Model
{
    use HasFactory;

    /**
     * Declare relationship Many to One with Vehicles
     *
     * @return relationship
     */
    public function vehicles()
    {
        return $this->belongsTo(Vehicles::class, 'vehicle_id');
    }

    /**
     * Declare relationship Many to One with Calipers
     *
     * @return relationship
     */
    public function calipers()
    {
        return $this->belongsTo(Calipers::class, 'caliper_id');
    }
}
