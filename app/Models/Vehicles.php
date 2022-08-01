<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;

    /**
     * Declare relationship One to Many with Caliper Vehicles
     *
     * @return relationship
     */
    public function caliperVehicles()
    {
        return $this->hasMany(CaliperVehicles::class, 'vehicle_id');
    }
}
