<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtralaboralA extends Model
{
    use HasFactory;

    protected $table = 'ext1';

    protected $primaryKey = 'registro';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'NumeroFolio',
        'registro',
        'empresa',
        'cedula',
        'p1',
        'p2',
        'p3',
        'p4',
        'p5',
        'p6',
        'p7',
        'p8',
        'p9',
        'p10',
        'p11',
        'p12',
        'p13',
        'periodo'
    ];  


    public function getTable()
    {
        // Determine the table name based on the user's role
        if (auth()->user()->nivelSeguridad == config('constants.TIPO_B')) {
            return 'ext1a';
        }

        return $this->table;
    }
}
