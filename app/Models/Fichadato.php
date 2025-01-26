<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichadato extends Model
{
    use HasFactory;

    protected $table = 'fichadatos';

    protected $primaryKey = 'NumeroFolio';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'registro',
        'cedula',
        'empresas',
        'nombre',
        'sexo',
        'edad',
        'anonaci',
        'edad',
        'estadociv',
        'nivelEstudio',
        'ocupacion', 
        'personal',
        'residenciaciudad',
        'residenciadepto',
        'nivelSeguridad',
        'estrato',
        'tipoVivienda',
        'lugartrabajocity',
        'lugartrabajodpto',
        'tiempotrabajo',
        'personasdependientes',
        'cargoempresa',
        'contratoactual',
        'tipocargo',
        'anoscargo',
        'nombredepto',
        'sede',
        'horastrabajo',
        'tiposalario',
        'tablacontestada',
        'serviciocliente',
        'soyjefe',
        'periodo',
        'procesos'
    ];

    protected $hidden = ['NumeroFolio'];
}
