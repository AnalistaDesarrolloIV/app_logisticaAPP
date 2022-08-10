<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    use HasFactory;
    
    public $table = 'DAT_OPERATORI';

    protected $primaryKey = 'OPE_ID';
    
    protected $fillable = [
        'OPE_OPERATORE',
        'OPE_EMAIL',
        'OPE_PSW',
        'OPE_TIPOLINGUA',
        'OPE_RUOLI',
        'OPE_ONLYWEB',
        'OPE_ALIAS',
        'OPE_AREEABI',
        'OPE_ZONEABI',
        'OPE_BANCHINE_GR',
        'OPE_DOMINIO',
        'OPE_TRUSTEDCON',
    ];

    public $timestamps = false;
}
