<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDemand extends Model
{
    use HasFactory;
    
    protected $table = 'status_demands';
    protected $fillable = ['title', 'codename'];

    public function demands() {
        // HasMany > Tem muitos

        return $this->hasMany('App\Models\Demand');
    }
}
