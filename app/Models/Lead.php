<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = [];
    
    /**
     * Get the service that the lead belongs to.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
