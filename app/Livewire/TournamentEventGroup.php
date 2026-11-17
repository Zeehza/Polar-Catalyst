<?php

namespace App\Livewire;

use App\Models\Tournament;
use App\Services\TournamentService;
use Livewire\Component;

class TournamentEventGroup extends Component
{
    public string $tournamentName;
    public string $game;
    public array $seasonIds = [];
    public string $activeSeasonId = '';
    public string $eventView = 'schedule'; // 'schedule' | 'bracket'

    public function mount(string $tournamentName, string $game, array $seasonIds)
    {
        $this->tournamentName = $tournamentName;
        $this->game = $game;
        $this->seasonIds = $seasonIds;

        $seasons = Tournament::whereIn('id', $this->seasonIds)->get();
        $sorted = $seasons->sort(function ($a, $b) {
            $weights = ['ONGOING' => 3, 'UPCOMING' => 2, 'COMPLETED' => 1, 'DRAFT' => 0];
            $diff = ($weights[$b->status] ?? 0) - ($weights[$a->status] ?? 0);
            if ($diff !== 0) return $diff;
            return $b->startDate <=> $a->startDate;
        });

        $this->activeSeasonId = $sorted->first()?->id ?? '';
    }

    public function selectSeason(string $seasonId)
    {
        $this->activeSeasonId = $seasonId;
    }

    public function setEventView(string $view)
    {
        $this->eventView = $view;
    }

    public function render()
    {
        $seasons = Tournament::with(['teams', 'matches.teamA', 'matches.teamB', 'matches.winner'])
            ->whereIn('id', $this->seasonIds)
            ->get()
            ->sort(function ($a, $b) {
                $weights = ['ONGOING' => 3, 'UPCOMING' => 2, 'COMPLETED' => 1, 'DRAFT' => 0];
                $diff = ($weights[$b->status] ?? 0) - ($weights[$a->status] ?? 0);
                if ($diff !== 0) return $diff;
                return $b->startDate <=> $a->startDate;
            });

        $activeSeason = $seasons->firstWhere('id', $this->activeSeasonId) ?? $seasons->first();

        $displayTeams = [];
        if ($activeSeason) {
            if ($activeSeason->type === 'PLAYOFF') {
                $displayTeams = $activeSeason->teams;
            } else {
                $groupLbs = TournamentService::getGroupLeaderboards($activeSeason->teams, $activeSeason->matches);
                $qualifiedIds = [];
                foreach ($groupLbs as $groupName => $lb) {
                    $top2 = array_slice($lb, 0, 2);
                    foreach ($top2 as $t) {
                        $qualifiedIds[$t['id']] = true;
                    }
                }
                $displayTeams = $activeSeason->teams->filter(fn($t) => isset($qualifiedIds[(string) $t->id]));
            }
        }

        $upcomingMatches = $activeSeason ? $activeSeason->matches->filter(fn($m) => $m->status !== 'COMPLETED') : collect();

        return view('livewire.tournament-event-group', [
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
            'displayTeams' => $displayTeams,
            'upcomingMatches' => $upcomingMatches,
            'eventView' => $this->eventView,
        ]);
    }
}
