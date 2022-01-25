<?php

namespace App\Models;

use App\Models\Agendamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $fillable = [
        'nome',
        'capacidade',
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
