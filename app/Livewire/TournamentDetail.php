<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Livewire\Component;
use Livewire\WithFileUploads;

class TournamentDetail extends Component
{
    use WithFileUploads;

    public string $tournamentId;

    // Info form
    public string $name = '';
    public string $season = '';
    public string $status = 'DRAFT';
    public string $type = 'PLAYOFF';
    public ?string $infoToast = null;

    // Add team form
    public string $newTeamName = '';
    public string $newTeamShortName = '';
    public string $newTeamLogoUrl = '';

    // Edit team logo form
    public ?string $editingTeamId = null;
    public string $editingTeamName = '';
    public string $editingTeamShortName = '';
    public string $editingTeamLogoUrl = '';
    public $editingTeamLogoFile = null;
    public ?string $teamToast = null;

    // Add match form
    public int $newMatchOrder = 1;
    public int $newRoundNumber = 1;
    public string $newTeamAId = '';
    public string $newTeamBId = '';
    public string $newScheduledAt = '';

    // Match edit inputs (indexed by match id)
    public array $matchScores = [];
    public array $matchWinners = [];
    public array $matchStatuses = [];
    public array $matchSchedules = [];
    public ?string $matchToast = null;

    public function mount(string $tournamentId)
    {
        abort_unless(auth('admin')->check(), 403);
        $this->tournamentId = $tournamentId;
        $this->loadTournamentData();
    }

    public function loadTournamentData()
    {
        $tournament = Tournament::with(['teams', 'matches.teamA', 'matches.teamB'])->findOrFail($this->tournamentId);
        $this->name = $tournament->name;
        $this->season = $tournament->season;
        $this->status = $tournament->status;
        $this->type = $tournament->type;

        foreach ($tournament->matches as $m) {
            $mId = (string) $m->id;
            $this->matchScores[$mId] = [
                'scoreA' => $m->scoreA,
                'scoreB' => $m->scoreB,
            ];

            // Winner default option
            if ($m->winnerId) {
                if (
                    ($m->scoreA !== null && $m->scoreB !== null && $m->scoreA > $m->scoreB && $m->winnerId === $m->teamAId) ||
                    ($m->scoreA !== null && $m->scoreB !== null && $m->scoreB > $m->scoreA && $m->winnerId === $m->teamBId)
                ) {
                    $this->matchWinners[$mId] = 'AUTO';
                } else {
                    $this->matchWinners[$mId] = $m->winnerId;
                }
            } else {
                if ($m->scoreA !== null && $m->scoreB !== null && $m->scoreA !== $m->scoreB) {
                    $this->matchWinners[$mId] = 'NONE';
                } else {
                    $this->matchWinners[$mId] = 'AUTO';
                }
            }

            $this->matchStatuses[$mId] = $m->status;
            $this->matchSchedules[$mId] = $m->scheduledAt ? $m->scheduledAt->format('Y-m-d\TH:i') : '';
        }
    }

    public function updateInfo()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'season' => 'required|string|max:50',
            'status' => 'required|string|in:DRAFT,ONGOING,COMPLETED',
            'type' => 'required|string|in:PLAYOFF,GROUP_STAGE',
        ]);

        $tournament = Tournament::findOrFail($this->tournamentId);
        $tournament->update([
            'name' => trim($this->name),
            'season' => trim($this->season),
            'status' => $this->status,
            'type' => $this->type,
        ]);

        $this->infoToast = 'Info turnamen terupdate!';
        $this->dispatch('hide-toast', target: 'info');
    }

    public function addTeam()
    {
        $this->validate([
            'newTeamName' => 'required|string|max:100',
            'newTeamShortName' => 'nullable|string|max:10',
            'newTeamLogoUrl' => 'nullable|url|max:500',
        ]);

        Team::create([
            'name' => trim($this->newTeamName),
            'shortName' => trim($this->newTeamShortName) ? strtoupper(trim($this->newTeamShortName)) : null,
            'logoUrl' => trim($this->newTeamLogoUrl) ?: null,
            'tournamentId' => $this->tournamentId,
        ]);

        $this->reset(['newTeamName', 'newTeamShortName', 'newTeamLogoUrl']);
    }

    public function updateTeamGroup(string $teamId, ?string $group)
    {
        $team = Team::where('tournamentId', $this->tournamentId)->find($teamId);
        if ($team) {
            $team->update(['group' => $group ?: null]);
        }
    }

    public function openEditLogoModal(string $teamId)
    {
        $team = Team::where('tournamentId', $this->tournamentId)->find($teamId);
        if (!$team) {
            return;
        }

        $this->editingTeamId = $team->id;
        $this->editingTeamName = $team->name;
        $this->editingTeamShortName = $team->shortName ?? '';
        $this->editingTeamLogoUrl = $team->logoUrl ?? '';
        $this->editingTeamLogoFile = null;
        $this->resetErrorBag();
    }

    public function closeEditLogoModal()
    {
        $this->editingTeamId = null;
        $this->editingTeamName = '';
        $this->editingTeamShortName = '';
        $this->editingTeamLogoUrl = '';
        $this->editingTeamLogoFile = null;
        $this->resetErrorBag();
    }

    public function saveTeamLogo()
    {
        if (!$this->editingTeamId) {
            return;
        }

        $team = Team::where('tournamentId', $this->tournamentId)->findOrFail($this->editingTeamId);

        if (!empty($this->editingTeamLogoUrl)) {
            $url = trim($this->editingTeamLogoUrl);
            if (!preg_match('~^(?:f|ht)tps?://~i', $url)) {
                $url = 'https://' . $url;
            }
            $this->editingTeamLogoUrl = $url;
        }

        $this->validate([
            'editingTeamShortName' => 'nullable|string|max:10',
            'editingTeamLogoUrl' => 'nullable|url|max:500',
            'editingTeamLogoFile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $finalLogoUrl = trim($this->editingTeamLogoUrl) ?: null;

        if ($this->editingTeamLogoFile) {
            $path = $this->editingTeamLogoFile->store('team-logos', 'public');
            $finalLogoUrl = asset('storage/' . $path);
        }

        $team->update([
            'shortName' => trim($this->editingTeamShortName) ? strtoupper(trim($this->editingTeamShortName)) : null,
            'logoUrl' => $finalLogoUrl,
        ]);

        $this->teamToast = "Data tim {$team->name} berhasil diperbarui!";
        $this->closeEditLogoModal();
        $this->dispatch('hide-toast', target: 'team');
    }

    public function removeTeamLogo(string $teamId)
    {
        $team = Team::where('tournamentId', $this->tournamentId)->find($teamId);
        if ($team) {
            $team->update(['logoUrl' => null]);
            $this->teamToast = "Logo tim {$team->name} dihapus!";
            $this->closeEditLogoModal();
            $this->dispatch('hide-toast', target: 'team');
        }
    }

    public function deleteTeam(string $teamId)
    {
        $team = Team::where('tournamentId', $this->tournamentId)->find($teamId);
        if ($team) {
            $team->delete();
        }
    }

    public function addMatch()
    {
        $this->validate([
            'newMatchOrder' => 'required|integer|min:1',
            'newRoundNumber' => 'required|integer|min:1',
        ]);

        $match = TournamentMatch::create([
            'tournamentId' => $this->tournamentId,
            'matchOrder' => $this->newMatchOrder,
            'roundNumber' => $this->newRoundNumber,
            'teamAId' => $this->newTeamAId ?: null,
            'teamBId' => $this->newTeamBId ?: null,
            'scheduledAt' => $this->newScheduledAt ? $this->newScheduledAt : null,
            'status' => 'SCHEDULED',
        ]);

        $this->loadTournamentData();
    }

    public function updateMatch(string $matchId)
    {
        $match = TournamentMatch::where('tournamentId', $this->tournamentId)->findOrFail($matchId);

        $scoreA = isset($this->matchScores[$matchId]['scoreA']) && $this->matchScores[$matchId]['scoreA'] !== ''
            ? (int) $this->matchScores[$matchId]['scoreA']
            : null;
        $scoreB = isset($this->matchScores[$matchId]['scoreB']) && $this->matchScores[$matchId]['scoreB'] !== ''
            ? (int) $this->matchScores[$matchId]['scoreB']
            : null;

        $winnerChoice = $this->matchWinners[$matchId] ?? 'AUTO';
        $winnerId = null;

        if ($winnerChoice === 'AUTO') {
            if ($scoreA !== null && $scoreB !== null) {
                if ($scoreA > $scoreB && $match->teamAId) $winnerId = $match->teamAId;
                elseif ($scoreB > $scoreA && $match->teamBId) $winnerId = $match->teamBId;
            }
        } elseif ($winnerChoice === 'NONE') {
            $winnerId = null;
        } else {
            // Validate that the chosen winner is one of the match participants
            if ($winnerChoice === $match->teamAId || $winnerChoice === $match->teamBId) {
                $winnerId = $winnerChoice;
            }
        }

        $status = $this->matchStatuses[$matchId] ?? 'SCHEDULED';
        if (!in_array($status, ['SCHEDULED', 'ONGOING', 'COMPLETED', 'CANCELLED'], true)) {
            $status = 'SCHEDULED';
        }
        $scheduledAt = !empty($this->matchSchedules[$matchId]) ? $this->matchSchedules[$matchId] : null;

        $playedAt = ($status === 'COMPLETED' && $match->status !== 'COMPLETED') ? now() : $match->playedAt;

        $match->update([
            'scoreA' => $scoreA,
            'scoreB' => $scoreB,
            'winnerId' => $winnerId,
            'status' => $status,
            'scheduledAt' => $scheduledAt,
            'playedAt' => $playedAt,
        ]);

        $this->matchToast = "Match M{$match->matchOrder}-G{$match->roundNumber} diperbarui!";
        $this->dispatch('hide-toast', target: 'match');
    }

    public function deleteMatch(string $matchId)
    {
        $match = TournamentMatch::where('tournamentId', $this->tournamentId)->find($matchId);
        if ($match) {
            $match->delete();
        }
    }

    public function deleteTournament()
    {
        $t = Tournament::findOrFail($this->tournamentId);
        $t->delete();
        return redirect()->route('admin.turnamen');
    }

    public function render()
    {
        $tournament = Tournament::with(['teams', 'matches.teamA', 'matches.teamB', 'matches.winner'])
            ->findOrFail($this->tournamentId);

        $siblingSeasons = Tournament::where('name', $tournament->name)
            ->orderByDesc('startDate')
            ->get();

        return view('livewire.tournament-detail', [
            'tournament' => $tournament,
            'siblingSeasons' => $siblingSeasons,
            'tournamentId' => $this->tournamentId,
        ]);
    }
}
