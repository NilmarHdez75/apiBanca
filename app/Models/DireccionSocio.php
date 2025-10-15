<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionSocio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'direcciones_socios';
    protected $primaryKey = 'id_direccion';

    protected $fillable = [
        'id_socio',
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

    public function socio(): BelongsTo{
        return $this->belongsTo(Socio::class, 'id_socio');
    }
}
