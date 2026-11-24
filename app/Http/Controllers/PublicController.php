<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Services\TournamentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function events()
    {
        $v = TournamentService::getCacheVersion();
        $tournamentGroups = Cache::remember("public_events_groups_v{$v}", 3600, function () {
            $tournaments = Tournament::whereIn('status', ['ONGOING', 'UPCOMING', 'COMPLETED'])
                ->orderByDesc('startDate')
                ->get();

            $groupedMap = [];
            foreach ($tournaments as $t) {
                if (!isset($groupedMap[$t->name])) {
                    $groupedMap[$t->name] = [
                        'tournamentName' => $t->name,
                        'game' => $t->game,
                        'seasonIds' => [$t->id],
                    ];
                } else {
                    $groupedMap[$t->name]['seasonIds'][] = $t->id;
                }
            }

            return array_values($groupedMap);
        });

        return view('events', [
            'tournamentGroups' => $tournamentGroups,
        ]);
    }

    public function results()
    {
        $v = TournamentService::getCacheVersion();
        $tournamentGroups = Cache::remember("public_results_groups_v{$v}", 3600, function () {
            $tournaments = Tournament::whereIn('status', ['ONGOING', 'COMPLETED'])
                ->orderByDesc('startDate')
                ->get();

            $groupedMap = [];
            foreach ($tournaments as $t) {
                if (!isset($groupedMap[$t->name])) {
                    $groupedMap[$t->name] = [
                        'tournamentName' => $t->name,
                        'game' => $t->game,
                        'seasonIds' => [$t->id],
                    ];
                } else {
                    $groupedMap[$t->name]['seasonIds'][] = $t->id;
                }
            }

            return array_values($groupedMap);
        });

        return view('results', [
            'tournamentGroups' => $tournamentGroups,
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('login');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
