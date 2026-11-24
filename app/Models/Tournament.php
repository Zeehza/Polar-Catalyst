<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasUlids;

    protected $table = 'tournaments';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'name',
        'season',
        'slug',
        'description',
        'game',
        'type',
        'status',
        'bannerUrl',
        'startDate',
        'endDate',
    ];

    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
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

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'tournamentId')->orderBy('name', 'asc');
    }

    public function matches(): HasMany
    {
        return $this->hasMany(TournamentMatch::class, 'tournamentId')
            ->orderBy('matchOrder', 'asc')
            ->orderBy('roundNumber', 'asc');
    }
}
