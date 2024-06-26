<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model{

    use HasFactory;

    protected $table      = 'tbplano';
    protected $primaryKey = 'placodigo';

    protected $fillable = [
        'pladescricao',
        'plaquantidadedias',
        'plavalor',
        'plaquantidadeparcela',
        'lojcodigo'
    ];

}
