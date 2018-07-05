<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    public $timestamps = false;
    protected $table = 'proveedores';
    protected $fillable = ['id','contacto', 'telefono_contacto'];

    public function persona(){
        return $this->belongsTo('App\Persona');
    }
}
