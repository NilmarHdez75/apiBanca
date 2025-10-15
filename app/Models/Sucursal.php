<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'sucursales';
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'is_active',
    ];

    public function socio(): HasMany{
        return $this->hasMany(Socio::class);
    }
}
