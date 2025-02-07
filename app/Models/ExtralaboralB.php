<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtralaboralB extends Model
{
    use HasFactory;

    protected $table = 'ext2';

    protected $primaryKey = 'registro';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'NumeroFolio',
        'registro',
        'empresa',
        'cedula',
        'p14',
        'p15',
        'p16',
        'p17',
        'p18',
        'p19',
        'p20',
        'p21',
        'p22',
        'p23',
        'p24',
        'p25',
        'p26',
        'p27',
        'p28',
        'p29',
        'p30',
        'p31',
        'periodo'
    ];
    
    public function getTable()
    {
        // Determine the table name based on the user's role
        if (auth()->user()->nivelSeguridad == config('constants.TIPO_B')) {
            return 'ext2a';
        }

        return $this->table;
    }
}
