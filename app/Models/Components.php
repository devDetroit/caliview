<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Components extends Model
{
    use HasFactory;

    /**
     * Declare relationship Many to One with Component Types
     *
     * @return relationship
     */
    public function componentTypes()
    {
        return $this->belongsTo(ComponentTypes::class, 'type_id');
    }
}
