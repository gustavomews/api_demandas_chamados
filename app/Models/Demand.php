<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'datetime_open', 'datetime_end', 'user_id', 'status'];

    // Status
    // 1 - Pendente
    // 2 - Em andamento
    // 3 - Concluído
    // 4 - Cancelado

    public function user()
    {
        // BelongsTo > Pertence à

        return $this->BelongsTo('App\Models\User');
    }

    public function status()
    {
        // BelongsTo > Pertence à

        return $this->BelongsTo('App\Models\StatusDemand');
    }

    public function interactions()
    {
        // hasMany > Tem muitos

        return $this->hasMany('App\Models\Interaction');
    }
}
