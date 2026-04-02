<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dashboard extends Model
{
    use HasFactory;

    protected $table = 'dashboards';

    protected $fillable = [
        'usuario_id',
        'initial_balance',
        'future_balance',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'future_balance' => 'decimal:2',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id', 'usu_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(FinanceEntry::class, 'dashboard_id', 'id');
    }
}
