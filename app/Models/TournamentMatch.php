<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentMatch extends Model
{
    use HasUlids;

    protected $table = 'matches';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'tournamentId',
        'roundNumber',
        'matchOrder',
        'teamAId',
        'teamBId',
        'scoreA',
        'scoreB',
        'winnerId',
        'status',
        'scheduledAt',
        'playedAt',
        'notes',
    ];

    protected $casts = [
        'roundNumber' => 'integer',
        'matchOrder' => 'integer',
        'scoreA' => 'integer',
        'scoreB' => 'integer',
        'scheduledAt' => 'datetime',
        'playedAt' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            \App\Services\TournamentService::clearPublicCache();
        });

        static::deleted(function () {
            \App\Services\TournamentService::clearPublicCache();
        });
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournamentId');
    }

    public function teamA(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'teamAId');
    }

    public function teamB(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'teamBId');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winnerId');
    }
}
