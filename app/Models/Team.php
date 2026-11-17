<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasUlids;

    protected $table = 'teams';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'name',
        'logoUrl',
        'tournamentId',
        'seed',
        'group',
        'status',
    ];

    protected $casts = [
        'seed' => 'integer',
        'createdAt' => 'datetime',
    ];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournamentId');
    }

    public function matchesAsA(): HasMany
    {
        return $this->hasMany(TournamentMatch::class, 'teamAId');
    }

    public function matchesAsB(): HasMany
    {
        return $this->hasMany(TournamentMatch::class, 'teamBId');
    }

    public function matchesWon(): HasMany
    {
        return $this->hasMany(TournamentMatch::class, 'winnerId');
    }
}
