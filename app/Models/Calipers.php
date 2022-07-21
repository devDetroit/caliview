<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calipers extends Model
{
    use HasFactory;

    /**
     * Declare relationship Many to One with Caliper Families
     *
     * @return relationship
     */
    public function caliperFamilies()
    {
        return $this->belongsTo(CaliperFamilies::class, 'family_id');
    }
}
