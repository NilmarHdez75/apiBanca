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
        return $this->belongsTo(User::class);
    }

    public function direccion(): HasOne{
        return $this->hasOne(DireccionSocio::class);
    }

    public function beneficiarios(): HasMany{
        return $this->hasMany(Beneficiario::class);
    }

    public function cuentas(): HasMany{
        return $this->hasMany(Cuenta::class);
    }

    public function contratos(): HasMany{
        return $this->hasMany(Contrato::class);
    }

    public function sucursal(): BelongsTo{
        return $this->belongsTo(Sucursal::class);
    }
}
