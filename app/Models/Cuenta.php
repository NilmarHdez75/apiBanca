<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_cuenta';

    protected $fillable = [
        'id_socio',
        'tipo_cuenta',
        'saldo',
        'fecha_apertura',
        'is_active',
    ];

    public function socio(): BelongsTo{
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function movimientos(): HasMany{
        return $this->hasMany(Movimiento::class, 'id_cuenta');
    }
}
