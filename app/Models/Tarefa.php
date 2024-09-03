<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'finalizada',
        'data_termino',
        'prioridade_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data_termino' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($tarefa) {
            $tarefa->user_id = Auth::id();
        });
    }
}
