<?php

namespace App\Services;

class TournamentService
{
    /**
     * Menghitung leaderboard turnamen (Playoff / Group Stage).
     */
    public static function getLeaderboard(iterable $teams, iterable $matches, string $tournamentType = 'PLAYOFF'): array
    {
        $stats = [];

        foreach ($teams as $team) {
            $teamId = (string) $team->id;
            $stats[$teamId] = [
                'id' => $teamId,
                'name' => $team->name,
                'logoUrl' => $team->logoUrl ?? null,
                'group' => $team->group ?? null,
                'played' => 0,
                'wins' => 0,
                'losses' => 0,
                'points' => 0,
                'bracketPlacement' => 999,
                'stageTitle' => null,
                'netDiff' => 0,
                'winRate' => 0.0,
            ];
        }

        foreach ($matches as $match) {
            if ($match->status && $match->status !== 'COMPLETED') {
                continue;
            }

            $aId = (string) ($match->teamAId ?? $match->teamA?->id ?? '');
            $bId = (string) ($match->teamBId ?? $match->teamB?->id ?? '');

            if ($aId && isset($stats[$aId])) {
                $stats[$aId]['played']++;
            }
            if ($bId && isset($stats[$bId])) {
                $stats[$bId]['played']++;
            }

            $winnerId = (string) ($match->winnerId ?? '');
            if ($winnerId && isset($stats[$winnerId])) {
                $stats[$winnerId]['wins']++;
                $stats[$winnerId]['points'] += 3;

                $loserId = ($winnerId === $aId) ? $bId : $aId;
                if ($loserId && isset($stats[$loserId])) {
                    $stats[$loserId]['losses']++;
                }
            }
        }

        foreach ($stats as &$team) {
            $team['netDiff'] = $team['wins'] - $team['losses'];
            $team['winRate'] = $team['played'] > 0 ? ($team['wins'] / $team['played']) * 100 : 0.0;
        }
        unset($team);

        // Untuk format PLAYOFF: peringkat ditentukan eliminasi bracket
        $matchesArray = is_array($matches) ? $matches : iterator_to_array($matches);
        if ($tournamentType === 'PLAYOFF' && count($matchesArray) > 0) {
            $seriesMap = [];
            foreach ($matchesArray as $m) {
                if ($m->status && $m->status !== 'COMPLETED') {
                    continue;
                }
                $seriesMap[$m->matchOrder][] = $m;
            }

            $seriesResults = [];
            foreach ($seriesMap as $matchOrder => $games) {
                $participants = [];
                $winCount = [];

                foreach ($games as $g) {
                    $aId = (string) ($g->teamAId ?? $g->teamA?->id ?? '');
                    $bId = (string) ($g->teamBId ?? $g->teamB?->id ?? '');
                    if ($aId) $participants[$aId] = $g->teamA?->name ?? $aId;
                    if ($bId) $participants[$bId] = $g->teamB?->name ?? $bId;

                    $wId = (string) ($g->winnerId ?? '');
                    if ($wId) {
                        $winCount[$wId] = ($winCount[$wId] ?? 0) + 1;
                    }
                }

                $participantIds = array_keys($participants);
                if (count($participantIds) >= 2) {
                    $id1 = $participantIds[0];
                    $id2 = $participantIds[1];
                    $w1 = $winCount[$id1] ?? 0;
                    $w2 = $winCount[$id2] ?? 0;

                    if ($w1 > $w2) {
                        $seriesResults[] = ['matchOrder' => $matchOrder, 'winnerId' => $id1, 'loserId' => $id2];
                    } elseif ($w2 > $w1) {
                        $seriesResults[] = ['matchOrder' => $matchOrder, 'winnerId' => $id2, 'loserId' => $id1];
                    } else {
                        $lastGame = end($games);
                        if (!empty($lastGame->winnerId)) {
                            $wId = (string) $lastGame->winnerId;
                            $lId = ($wId === $id1) ? $id2 : $id1;
                            $seriesResults[] = ['matchOrder' => $matchOrder, 'winnerId' => $wId, 'loserId' => $lId];
                        }
                    }
                }
            }

            usort($seriesResults, fn($a, $b) => $b['matchOrder'] - $a['matchOrder']);

            if (count($seriesResults) > 0) {
                $grandFinal = $seriesResults[0];
                $rankedIds = [];

                if (isset($stats[$grandFinal['winnerId']])) {
                    $stats[$grandFinal['winnerId']]['bracketPlacement'] = 1;
                    $stats[$grandFinal['winnerId']]['stageTitle'] = 'Juara 1 (Champion)';
                    $rankedIds[$grandFinal['winnerId']] = true;
                }

                if (isset($stats[$grandFinal['loserId']])) {
                    $stats[$grandFinal['loserId']]['bracketPlacement'] = 2;
                    $stats[$grandFinal['loserId']]['stageTitle'] = 'Juara 2 (Runner-up)';
                    $rankedIds[$grandFinal['loserId']] = true;
                }

                $nextRank = 3;
                $count = count($seriesResults);
                for ($i = 1; $i < $count; $i++) {
                    $loserId = $seriesResults[$i]['loserId'];
                    if ($loserId && isset($stats[$loserId]) && !isset($rankedIds[$loserId])) {
                        $stats[$loserId]['bracketPlacement'] = $nextRank;
                        $stats[$loserId]['stageTitle'] = ($nextRank === 3) ? 'Juara 3' : "Peringkat {$nextRank}";
                        $rankedIds[$loserId] = true;
                        $nextRank++;
                    }
                }
            }
        }

        $list = array_values($stats);
        usort($list, function ($a, $b) {
            if ($a['bracketPlacement'] !== $b['bracketPlacement']) {
                return $a['bracketPlacement'] <=> $b['bracketPlacement'];
            }
            if ($b['winRate'] !== $a['winRate']) {
                return $b['winRate'] <=> $a['winRate'];
            }
            if ($b['wins'] !== $a['wins']) {
                return $b['wins'] <=> $a['wins'];
            }
            if ($b['netDiff'] !== $a['netDiff']) {
                return $b['netDiff'] <=> $a['netDiff'];
            }
            if ($b['points'] !== $a['points']) {
                return $b['points'] <=> $a['points'];
            }
            return strcmp($a['name'], $b['name']);
        });

        return $list;
    }

    /**
     * Menghitung leaderboard per grup untuk format GROUP_STAGE.
     */
    public static function getGroupLeaderboards(iterable $teams, iterable $matches): array
    {
        $groups = [];
        $teamGroupMap = [];

        foreach ($teams as $team) {
            $group = $team->group ?: 'Tidak Ada Grup';
            $groups[$group][] = $team;
            $teamGroupMap[(string) $team->id] = $group;
        }

        $result = [];
        $matchesArray = is_array($matches) ? $matches : iterator_to_array($matches);

        foreach ($groups as $groupName => $groupTeams) {
            $groupMatches = array_filter($matchesArray, function ($match) use ($teamGroupMap, $groupName) {
                $aGroup = isset($match->teamAId) ? ($teamGroupMap[(string) $match->teamAId] ?? null) : null;
                $bGroup = isset($match->teamBId) ? ($teamGroupMap[(string) $match->teamBId] ?? null) : null;
                return $aGroup === $groupName && $bGroup === $groupName;
            });

            $result[$groupName] = self::getLeaderboard($groupTeams, $groupMatches, 'GROUP_STAGE');
        }

        uksort($result, function ($a, $b) {
            if ($a === 'Tidak Ada Grup') return 1;
            if ($b === 'Tidak Ada Grup') return -1;
            return strcmp($a, $b);
        });

        return $result;
    }

    /**
     * Menghitung struktur bagan playoff (Single / Double Elimination) Challonge style.
     */
    public static function getBracketData(iterable $matches): array
    {
        $matchesArray = is_array($matches) ? $matches : iterator_to_array($matches);
        if (empty($matchesArray)) {
            return [
                'isDoubleElimination' => false,
                'upperRounds' => [],
                'lowerRounds' => [],
                'grandFinal' => null,
                'singleElimRounds' => [],
                'bronzeMatch' => null,
            ];
        }

        $seriesMap = [];
        foreach ($matchesArray as $m) {
            $mOrder = (int) $m->matchOrder;
            if (!isset($seriesMap[$mOrder])) {
                $seriesMap[$mOrder] = [
                    'matchOrder' => $mOrder,
                    'teamA' => $m->teamA ? ['id' => (string) $m->teamA->id, 'name' => $m->teamA->name, 'logoUrl' => $m->teamA->logoUrl] : null,
                    'teamB' => $m->teamB ? ['id' => (string) $m->teamB->id, 'name' => $m->teamB->name, 'logoUrl' => $m->teamB->logoUrl] : null,
                    'games' => [],
                    'gamesWonA' => 0,
                    'gamesWonB' => 0,
                    'winnerId' => null,
                    'status' => 'SCHEDULED',
                    'scheduledAt' => $m->scheduledAt,
                ];
            }

            $seriesMap[$mOrder]['games'][] = $m;

            if (!$seriesMap[$mOrder]['teamA'] && $m->teamA) {
                $seriesMap[$mOrder]['teamA'] = ['id' => (string) $m->teamA->id, 'name' => $m->teamA->name, 'logoUrl' => $m->teamA->logoUrl];
            } elseif (!$seriesMap[$mOrder]['teamB'] && $m->teamB && $seriesMap[$mOrder]['teamA'] && (string) $m->teamB->id !== $seriesMap[$mOrder]['teamA']['id']) {
                $seriesMap[$mOrder]['teamB'] = ['id' => (string) $m->teamB->id, 'name' => $m->teamB->name, 'logoUrl' => $m->teamB->logoUrl];
            } elseif (!$seriesMap[$mOrder]['teamB'] && $m->teamA && $seriesMap[$mOrder]['teamA'] && (string) $m->teamA->id !== $seriesMap[$mOrder]['teamA']['id']) {
                $seriesMap[$mOrder]['teamB'] = ['id' => (string) $m->teamA->id, 'name' => $m->teamA->name, 'logoUrl' => $m->teamA->logoUrl];
            }

            if ($m->status === 'ONGOING') {
                $seriesMap[$mOrder]['status'] = 'ONGOING';
            } elseif ($m->status === 'COMPLETED' && $seriesMap[$mOrder]['status'] !== 'ONGOING') {
                $seriesMap[$mOrder]['status'] = 'COMPLETED';
            }
        }

        ksort($seriesMap);
        $allSeries = array_values($seriesMap);

        foreach ($allSeries as &$series) {
            $idA = $series['teamA']['id'] ?? null;
            $idB = $series['teamB']['id'] ?? null;

            foreach ($series['games'] as $g) {
                $wId = $g->winnerId ? (string) $g->winnerId : null;
                if (!$wId) continue;
                if ($idA && $wId === $idA) {
                    $series['gamesWonA']++;
                } elseif ($idB && $wId === $idB) {
                    $series['gamesWonB']++;
                }
            }

            if ($series['gamesWonA'] > $series['gamesWonB'] && $series['teamA']) {
                $series['winnerId'] = $series['teamA']['id'];
            } elseif ($series['gamesWonB'] > $series['gamesWonA'] && $series['teamB']) {
                $series['winnerId'] = $series['teamB']['id'];
            } else {
                $lastGame = end($series['games']);
                if (!empty($lastGame->winnerId)) {
                    $series['winnerId'] = (string) $lastGame->winnerId;
                }
            }
        }
        unset($series);

        $lostTeams = [];
        $losersPlayingAgain = 0;

        foreach ($allSeries as $s) {
            $aId = $s['teamA']['id'] ?? null;
            $bId = $s['teamB']['id'] ?? null;
            $aLost = $aId && isset($lostTeams[$aId]);
            $bLost = $bId && isset($lostTeams[$bId]);

            if ($aLost || $bLost) {
                $losersPlayingAgain++;
            }

            if ($s['winnerId']) {
                $loserId = ($aId && $s['winnerId'] === $aId) ? $bId : $aId;
                if ($loserId) $lostTeams[$loserId] = true;
            }
        }

        $isDouble = ($losersPlayingAgain >= 2);

        if ($isDouble) {
            $maxOrder = max(array_column($allSeries, 'matchOrder'));
            $grandFinal = null;
            $lostBeforeSet = [];
            $upperList = [];
            $lowerList = [];

            foreach ($allSeries as $s) {
                if ($s['matchOrder'] === $maxOrder) {
                    $grandFinal = $s;
                    continue;
                }

                $aId = $s['teamA']['id'] ?? null;
                $bId = $s['teamB']['id'] ?? null;
                $aLost = $aId && isset($lostBeforeSet[$aId]);
                $bLost = $bId && isset($lostBeforeSet[$bId]);

                if ($aLost || $bLost) {
                    $lowerList[] = $s;
                } else {
                    $upperList[] = $s;
                }

                if ($s['winnerId']) {
                    $loserId = ($aId && $s['winnerId'] === $aId) ? $bId : $aId;
                    if ($loserId) $lostBeforeSet[$loserId] = true;
                }
            }

            $upperRounds = [];
            $uCount = count($upperList);
            if ($uCount >= 7) {
                $upperRounds[] = ['title' => 'Upper Round 1', 'series' => array_slice($upperList, 0, 4)];
                $upperRounds[] = ['title' => 'Upper Semifinals', 'series' => array_slice($upperList, 4, 2)];
                $upperRounds[] = ['title' => 'Upper Final', 'series' => array_slice($upperList, 6)];
            } elseif ($uCount >= 3) {
                $upperRounds[] = ['title' => 'Upper Semifinals', 'series' => array_slice($upperList, 0, 2)];
                $upperRounds[] = ['title' => 'Upper Final', 'series' => array_slice($upperList, 2)];
            } else {
                $upperRounds[] = ['title' => 'Upper Bracket', 'series' => $upperList];
            }

            $lowerRounds = [];
            $lCount = count($lowerList);
            if ($uCount >= 8 || $lCount >= 7) {
                $r1 = array_slice($lowerList, 0, 4);
                $r2 = array_slice($lowerList, 4, 4);
                $r3 = array_slice($lowerList, 8, 2);
                $r4 = array_slice($lowerList, 10, 2);
                $semi = array_slice($lowerList, 12, 1);
                $final = array_slice($lowerList, 13);

                if (!empty($r1)) $lowerRounds[] = ['title' => 'Lower Round 1', 'series' => $r1];
                if (!empty($r2)) $lowerRounds[] = ['title' => 'Lower Round 2', 'series' => $r2];
                if (!empty($r3)) $lowerRounds[] = ['title' => 'Lower Round 3', 'series' => $r3];
                if (!empty($r4)) $lowerRounds[] = ['title' => 'Lower Round 4', 'series' => $r4];
                if (!empty($semi)) $lowerRounds[] = ['title' => 'Lower Semifinal', 'series' => $semi];
                if (!empty($final)) $lowerRounds[] = ['title' => 'Lower Final', 'series' => $final];
            } elseif ($uCount >= 4 || $lCount >= 3) {
                $r1 = array_slice($lowerList, 0, 2);
                $r2 = array_slice($lowerList, 2, 2);
                $semi = array_slice($lowerList, 4, 1);
                $final = array_slice($lowerList, 5);

                if (!empty($r1)) $lowerRounds[] = ['title' => 'Lower Round 1', 'series' => $r1];
                if (!empty($r2)) $lowerRounds[] = ['title' => 'Lower Round 2', 'series' => $r2];
                if (!empty($semi)) $lowerRounds[] = ['title' => 'Lower Semifinal', 'series' => $semi];
                if (!empty($final)) $lowerRounds[] = ['title' => 'Lower Final', 'series' => $final];
            } elseif ($lCount >= 2) {
                $lowerRounds[] = ['title' => 'Lower Semifinal', 'series' => array_slice($lowerList, 0, 1)];
                $lowerRounds[] = ['title' => 'Lower Final', 'series' => array_slice($lowerList, 1)];
            } elseif ($lCount === 1) {
                $lowerRounds[] = ['title' => 'Lower Semifinal', 'series' => $lowerList];
            } else {
                $lowerRounds[] = ['title' => 'Lower Bracket', 'series' => $lowerList];
            }

            return [
                'isDoubleElimination' => true,
                'upperRounds' => $upperRounds,
                'lowerRounds' => $lowerRounds,
                'grandFinal' => $grandFinal,
                'singleElimRounds' => [],
                'bronzeMatch' => null,
            ];
        } else {
            $bronze = null;
            $mainSeries = $allSeries;
            $sCount = count($allSeries);

            if ($sCount >= 4) {
                $maxOrder = max(array_column($allSeries, 'matchOrder'));
                $finalMatch = null;
                foreach ($allSeries as $s) {
                    if ($s['matchOrder'] === $maxOrder) $finalMatch = $s;
                }
                $candidateBronze = $allSeries[$sCount - 2] ?? null;
                if ($candidateBronze && $finalMatch) {
                    $bWinner = $candidateBronze['winnerId'] ?? null;
                    if ($bWinner && $bWinner !== ($finalMatch['teamA']['id'] ?? null) && $bWinner !== ($finalMatch['teamB']['id'] ?? null)) {
                        $bronze = $candidateBronze;
                        $mainSeries = array_filter($allSeries, fn($s) => $s['matchOrder'] !== $candidateBronze['matchOrder']);
                        $mainSeries = array_values($mainSeries);
                    }
                }
            }

            $singleElimRounds = [];
            $mCount = count($mainSeries);
            if ($mCount >= 15) {
                $singleElimRounds[] = ['title' => 'Round of 16', 'series' => array_slice($mainSeries, 0, 8)];
                $singleElimRounds[] = ['title' => 'Quarterfinals', 'series' => array_slice($mainSeries, 8, 4)];
                $singleElimRounds[] = ['title' => 'Semifinals', 'series' => array_slice($mainSeries, 12, 2)];
                $singleElimRounds[] = ['title' => 'Grand Final', 'series' => array_slice($mainSeries, 14)];
            } elseif ($mCount >= 7) {
                $singleElimRounds[] = ['title' => 'Quarterfinals', 'series' => array_slice($mainSeries, 0, 4)];
                $singleElimRounds[] = ['title' => 'Semifinals', 'series' => array_slice($mainSeries, 4, 2)];
                $singleElimRounds[] = ['title' => 'Grand Final', 'series' => array_slice($mainSeries, 6)];
            } elseif ($mCount >= 3) {
                $singleElimRounds[] = ['title' => 'Semifinals', 'series' => array_slice($mainSeries, 0, 2)];
                $singleElimRounds[] = ['title' => 'Grand Final', 'series' => array_slice($mainSeries, 2)];
            } else {
                $singleElimRounds[] = ['title' => 'Playoff Final', 'series' => $mainSeries];
            }

            return [
                'isDoubleElimination' => false,
                'upperRounds' => [],
                'lowerRounds' => [],
                'grandFinal' => null,
                'singleElimRounds' => $singleElimRounds,
                'bronzeMatch' => $bronze,
            ];
        }
    }
}
