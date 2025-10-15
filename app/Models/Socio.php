<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_socio';

    protected $fillable = [
        'user_id',
        'numero_socio',
        'apellido_paterno',
        'apellido_materno',
        'genero',
        'fecha_nacimiento',
        'nacionalidad',
        'curp',
        'rfc',
        'ine',
        'telefono',
        'id_sucursal',
        'is_active',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function direccion(): HasOne{
        return $this->hasOne(DireccionSocio::class, 'id_socio');
    }

    public function beneficiarios(): HasMany{
        return $this->hasMany(Beneficiario::class, 'id_socio');
    }

    public function cuentas(): HasMany{
        return $this->hasMany(Cuenta::class, 'id_socio');
    }

    public function contratos(): HasMany{
        return $this->hasMany(Contrato::class, 'id_socio');
    }

    public function sucursal(): BelongsTo{
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }
}
