<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id_cuenta',
        'tipo_movimiento',
        'monto',
        'fecha_movimiento',
        'is_active',
    ];

    public function cuenta(): BelongsTo{
        return $this->belongsTo(Cuenta::class);
    }
}
