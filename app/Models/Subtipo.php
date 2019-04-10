<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tipo;
use App\Models\Donacion;

class Subtipo extends Model
{
    protected $table = 'subtipos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function donacion()
    {
        return $this->hasMany(Donacion::class, 'subtipos_id');
    }


    public function tipos(){
        return $this->belongsTo('App\Models\Tipo', 'tipos_id');
    }

}
