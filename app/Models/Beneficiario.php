<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiario extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id_socio',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'parentesco',
        'porcentaje',
        'is_active',
    ];

    public function socio(): BelongsTo{
        return $this->belongsTo(Socio::class);
    }

    public function direccion(): HasOne{
        return $this->hasOne(DireccionBeneficiario::class);
    }
}
