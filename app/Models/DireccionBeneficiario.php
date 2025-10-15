<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionBeneficiario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'direcciones_beneficiarios';
    protected $primaryKey = 'id_direccion';

    protected $fillable = [
        'id_beneficiario',
        'calle',
        'numero_ext',
        'numero_int',
        'colonia',
        'municipio',
        'estado',
        'cp',
        'pais',
        'is_active',
    ];

    public function beneficiario(): BelongsTo{
        return $this->belongsTo(Beneficiario::class, 'id_beneficiario');
    }
}
