<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    /**
     * Declare relationship Many to One with Component Type
     *
     * @return relationship
     */
    public function componentType()
    {
        return $this->belongsTo(ComponentType::class, 'type_id');
    }
}
