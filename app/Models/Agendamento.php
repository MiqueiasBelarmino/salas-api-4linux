<?php

namespace App\Models;

use App\Models\Models\Sala;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'data_inicio',
        'data_termino',
        'sala_id',
    ];


    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}
