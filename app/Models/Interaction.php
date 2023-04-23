<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = ['demand_id', 'user_id', 'description'];

    public function demand()
    {
        // BelongsTo > Pertence à

        return $this->BelongsTo('App\Models\Demand');
    }

    public function user()
    {
        // BelongsTo > Pertence à

        return $this->BelongsTo('App\Models\User');
    }
}
