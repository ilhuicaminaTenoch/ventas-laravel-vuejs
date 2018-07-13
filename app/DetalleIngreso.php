<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    public $table = 'detalle_ingresos';
    public $timestamps = false;
    public $fillable = [
        'idingreso',
        'idarticulo',
        'cantidad',
        'precio'
    ];
}
