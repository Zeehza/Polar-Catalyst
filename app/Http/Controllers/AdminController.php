<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalTournaments = Tournament::count();
        $activeTournaments = Tournament::where('status', 'ONGOING')->count();
        $unreadMessagesCount = ContactSubmission::where('isRead', false)->count();
        $totalTeams = Team::count();

        $recentMessages = ContactSubmission::orderByDesc('createdAt')->take(3)->get();

        return view('admin.dashboard', [
            'totalTournaments' => $totalTournaments,
            'activeTournaments' => $activeTournaments,
            'unreadMessagesCount' => $unreadMessagesCount,
            'totalTeams' => $totalTeams,
            'recentMessages' => $recentMessages,
        ]);
    }

    public function turnamen()
    {
        $tournaments = Tournament::withCount(['teams', 'matches'])
            ->orderByDesc('startDate')
            ->get();

        $groupedMap = [];
        foreach ($tournaments as $t) {
            if (!isset($groupedMap[$t->name])) {
                $groupedMap[$t->name] = [
                    'name' => $t->name,
                    'game' => $t->game,
                    'seasons' => [$t],
                ];
            } else {
                $groupedMap[$t->name]['seasons'][] = $t;
            }
        }

        return view('admin.turnamen.index', [
            'groupedTournaments' => array_values($groupedMap),
        ]);
    }

    public function createTurnamen(Request $request)
    {
        return view('admin.turnamen.create', [
            'initialName' => $request->query('name', ''),
            'initialGame' => $request->query('game', ''),
        ]);
    }

    public function showTurnamen(string $id)
    {
        $tournament = Tournament::findOrFail($id);

        return view('admin.turnamen.show', [
            'id' => $tournament->id,
            'tournament' => $tournament,
        ]);
    }

    public function pesan()
    {
        return view('admin.pesan');
    }
}
