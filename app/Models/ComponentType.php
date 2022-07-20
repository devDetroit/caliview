<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
    use HasFactory;
    
    /**
     * Declare relationship One to Many with Component
     *
     * @return relationship
     */
    public function compontent() {
        return $this->hasMany(Component::class, 'type_id');
    }
}