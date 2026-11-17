<?php

namespace App\Livewire;

use App\Models\Tournament;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateTournamentForm extends Component
{
    public string $mode = 'new'; // 'existing' | 'new'
    public array $existingTournaments = [];
    public string $selectedTournamentName = '';

    public string $name = '';
    public string $game = '';
    public string $season = 'Season 1';
    public string $type = 'PLAYOFF';
    public string $startDate = '';

    public ?string $errorMessage = null;

    protected $rules = [
        'name' => 'required|string|max:100',
        'game' => 'required|string|max:100',
        'season' => 'required|string|max:50',
        'type' => 'required|in:PLAYOFF,GROUP_STAGE',
        'startDate' => 'required|date',
    ];

    public function mount(string $initialName = '', string $initialGame = '')
    {
        $all = Tournament::orderByDesc('createdAt')->get();
        $grouped = [];

        foreach ($all as $t) {
            if (!isset($grouped[$t->name])) {
                $grouped[$t->name] = [
                    'name' => $t->name,
                    'game' => $t->game,
                    'seasons' => [$t->season],
                ];
            } else {
                if (!in_array($t->season, $grouped[$t->name]['seasons'])) {
                    $grouped[$t->name]['seasons'][] = $t->season;
                }
            }
        }

        $this->existingTournaments = array_values($grouped);

        $matched = null;
        if (!empty($initialName)) {
            foreach ($this->existingTournaments as $t) {
                if (strtolower($t['name']) === strtolower($initialName)) {
                    $matched = $t;
                    break;
                }
            }
        }

        if ($matched || (!empty($initialName) && count($this->existingTournaments) > 0)) {
            $this->mode = 'existing';
            $this->selectedTournamentName = $matched ? $matched['name'] : $initialName;
            $this->name = $this->selectedTournamentName;
            $this->game = $matched ? $matched['game'] : $initialGame;
            $this->season = $matched ? $this->getNextSeasonSuggestion($matched['seasons']) : 'Season 2';
        } elseif (count($this->existingTournaments) > 0) {
            $this->mode = 'new';
            $this->name = $initialName;
            $this->game = $initialGame;
            $this->season = 'Season 1';
        } else {
            $this->mode = 'new';
            $this->name = $initialName;
            $this->game = $initialGame;
            $this->season = 'Season 1';
        }
    }

    public function setMode(string $mode)
    {
        $this->mode = $mode;
        if ($mode === 'existing' && count($this->existingTournaments) > 0) {
            $target = $this->existingTournaments[0];
            $this->selectedTournamentName = $target['name'];
            $this->name = $target['name'];
            $this->game = $target['game'];
            $this->season = $this->getNextSeasonSuggestion($target['seasons']);
        } else {
            $this->name = '';
            $this->game = '';
            $this->season = 'Season 1';
        }
    }

    public function updatedSelectedTournamentName($value)
    {
        $this->name = $value;
        foreach ($this->existingTournaments as $t) {
            if ($t['name'] === $value) {
                $this->game = $t['game'];
                $this->season = $this->getNextSeasonSuggestion($t['seasons']);
                break;
            }
        }
    }

    public function useSuggestedSeason(string $suggested)
    {
        $this->season = $suggested;
    }

    protected function getNextSeasonSuggestion(array $seasons): string
    {
        $maxNum = 0;
        foreach ($seasons as $s) {
            if (preg_match('/(?:season|s)\s*(\d+)/i', $s, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxNum) $maxNum = $num;
            }
        }
        return $maxNum > 0 ? "Season " . ($maxNum + 1) : "Season " . (count($seasons) + 1);
    }

    public function submit()
    {
        $this->errorMessage = null;
        $this->validate();

        $existing = Tournament::where('name', trim($this->name))
            ->where('season', trim($this->season))
            ->first();

        if ($existing) {
            $this->errorMessage = "Turnamen \"{$this->name}\" dengan {$this->season} sudah ada. Silakan gunakan nama season lain (misal: Season 2).";
            return;
        }

        $cleanSlug = Str::slug("{$this->name} {$this->season}") . '-' . time();

        $tournament = Tournament::create([
            'name' => trim($this->name),
            'season' => trim($this->season),
            'slug' => $cleanSlug,
            'game' => trim($this->game),
            'type' => $this->type,
            'status' => 'DRAFT',
            'startDate' => $this->startDate,
        ]);

        return redirect()->route('admin.turnamen.detail', $tournament->id);
    }

    public function render()
    {
        $currentSeasons = [];
        foreach ($this->existingTournaments as $t) {
            if (strtolower($t['name']) === strtolower(trim($this->name))) {
                $currentSeasons = $t['seasons'];
                break;
            }
        }

        $isDuplicateSeason = in_array(strtolower(trim($this->season)), array_map('strtolower', array_map('trim', $currentSeasons)));
        $suggestedNextSeason = $this->getNextSeasonSuggestion($currentSeasons);

        return view('livewire.create-tournament-form', [
            'isDuplicateSeason' => $isDuplicateSeason,
            'suggestedNextSeason' => $suggestedNextSeason,
        ]);
    }
}
