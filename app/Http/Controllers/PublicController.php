<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function events()
    {
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

        return view('events', [
            'tournamentGroups' => array_values($groupedMap),
        ]);
    }

    public function results()
    {
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

        return view('results', [
            'tournamentGroups' => array_values($groupedMap),
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
