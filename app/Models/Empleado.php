<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class Empleado extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = 'empleados'; 

    protected $fillable = [
        'registro',
        'lugartrabajo',
        'nombre',
        'cargo',
        'cedula',
        'contrasena',
        'correo',
        'delaciudad',
        'deptociudad', 
        'personal',
        'areatrabajo',
        'sede',
        'nivelSeguridad',
        'fecha_subida',
        'tipoencuesta',
        'logo_empresa',
        'habilitado',
        'consentimiento',
        'fichadatos',
        'terminos',
        'adicional',
        'afrontamiento',
        'periodo',
        'procesos',
        'llave',
        'filtro'
    ];

    protected $hidden = ['contrasena'];

    public function getAuthPassword() { return $this->contrasena; }
    
    public function setContrasenaAttribute($value) { $this->attributes['contrasena'] = $value; }

}