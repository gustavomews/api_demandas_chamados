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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function rules() {
        return [
            'title' => 'required|min:5|max:40',
            'description' => 'max:2000'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O preenchimento é obrigatório!',
            'title.min' => 'O título deve possuir no mínimo 5 caracteres!',
            'title.max' => 'O título deve possuir no máximo 40 caracteres!',
            'description.max' => 'A descrição deve possuir no maximo 2000 caracteres!',
        ];
    }
}
