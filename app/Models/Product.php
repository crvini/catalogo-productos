<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'cantidad',
        'precio',
        'fecha_ingreso',
        'fecha_vencimiento',
        'foto',
    ];
}
