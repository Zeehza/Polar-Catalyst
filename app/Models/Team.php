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
        'name',
        'shortName',
        'logoUrl',
        'tournamentId',
        'seed',
        'group',
        'status',
    ];

    public function getShortCodeAttribute(): string
    {
        if (!empty($this->shortName)) {
            return strtoupper(trim($this->shortName));
        }

        $rawName = trim($this->name);
        $words = preg_split('/\s+/', $rawName);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } elseif (strlen($rawName) <= 4) {
            return strtoupper($rawName);
        }

        return strtoupper(substr($rawName, 0, 3));
    }

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
