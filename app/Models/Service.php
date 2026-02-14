<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];
    
    /**
     * Get the leads for the service.
     */
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
