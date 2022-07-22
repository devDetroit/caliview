<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaliperPhotos extends Model
{
    use HasFactory;

    /**
     * Declare relationship Many to One with Calipers
     *
     * @return relationship
     */
    public function calipers()
    {
        return $this->belongsTo(Calipers::class, 'caliper_id');
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
}
