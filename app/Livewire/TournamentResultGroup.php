<?php

namespace App\Livewire;

use App\Models\Tournament;
use App\Services\TournamentService;
use Livewire\Component;

class TournamentResultGroup extends Component
{
    public string $tournamentName;
    public string $game;
    public array $seasonIds = [];
    public string $activeSeasonId = '';
    public string $playoffView = 'bracket'; // 'bracket' | 'details'

    public function mount(string $tournamentName, string $game, array $seasonIds)
    {
        $this->tournamentName = $tournamentName;
        $this->game = $game;
        $this->seasonIds = $seasonIds;
        $this->activeSeasonId = $this->seasonIds[0] ?? '';
    }

    public function selectSeason(string $seasonId)
    {
        $this->activeSeasonId = $seasonId;
    }

    public function setPlayoffView(string $view)
    {
        $this->playoffView = $view;
    }

    public function render()
    {
        $seasons = Tournament::with(['teams', 'matches.teamA', 'matches.teamB', 'matches.winner'])
            ->whereIn('id', $this->seasonIds)
            ->get()
            ->sortByDesc('startDate')
            ->values();

        $activeSeason = $seasons->firstWhere('id', $this->activeSeasonId) ?? $seasons->first();
        if ($activeSeason && $this->activeSeasonId !== $activeSeason->id) {
            $this->activeSeasonId = $activeSeason->id;
        }

        $leaderboard = [];
        $groupLeaderboards = [];

        if ($activeSeason) {
            $leaderboard = TournamentService::getLeaderboard(
                $activeSeason->teams,
                $activeSeason->matches,
                $activeSeason->type
            );

            if ($activeSeason->type === 'GROUP_STAGE') {
                $groupLeaderboards = TournamentService::getGroupLeaderboards(
                    $activeSeason->teams,
                    $activeSeason->matches
                );
            }
        }

        return view('livewire.tournament-result-group', [
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
            'leaderboard' => $leaderboard,
            'groupLeaderboards' => $groupLeaderboards,
            'playoffView' => $this->playoffView,
        ]);
    }
}
