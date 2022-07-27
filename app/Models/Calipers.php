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

    /**
     * Declare relationship One to Many with Caliper Photos
     *
     * @return relationship
     */
    public function caliperPhotos()
    {
        return $this->hasMany(CaliperPhotos::class, 'caliper_id');
    }

    /**
     * Declare relationship Many to One with Users on the created_by column
     *
     * @return relationship
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Declare relationship Many to One with Users on the updated_by column
     *
     * @return relationship
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Declare relationship One to Many with Caliper Components
     *
     * @return relationship
     */
    public function caliperComponents()
    {
        return $this->hasMany(CaliperComponents::class, 'caliper_id');
    }
}
