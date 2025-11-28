<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrato extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'socio_id',
        'archivo_pdf',
        'fecha_generacion',
        'is_active',
    ];

    public function socio(): BelongsTo{
        return $this->belongsTo(Socio::class);
    }
}
