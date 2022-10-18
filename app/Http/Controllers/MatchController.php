<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatAverageRequest;
use App\Http\Requests\StatOvertimeRequest;
use App\Http\Requests\StatCharRequest;
use App\Http\Requests\StatSumRequest;
use App\Models\Character;
use App\Models\Game;

class MatchController extends Controller
{
    public function getChars() {
        return response()->json(Character::all());
    }

    public function statsForChar(StatCharRequest $request) {
        $stats = Game::ofCharacterName($request->input("name"))
                     ->ofUser($request->user()->id)->get();
        return response()->json($stats);
    }

    public function StatOverTime(StatOvertimeRequest $request) {
        $stats = Game::ofCharacterName($request->input("name"))
                     ->ofUser($request->user()->id)
                     ->select($request->input("stat"), "match_date")
                     ->orderBy("match_date")
                     ->whereBetween("match_date", [
                         $request->input("after"), $request->input("before")
                     ])->get();

        return response()->json($stats);
    }

    public function StatAverage(StatAverageRequest $request) {
        $response = [];
        $games    = Game::ofCharacterName($request->input("name"))
                        ->ofUser($request->user()->id)
                        ->get();
        foreach (Game::STATS as $stat) {
            $response[$stat] = number_format($games->pluck($stat)->average(), 2);
        }
        return ($request->input("stat"))
            ?
            response()->json($response[$request->input("stat")])
            :
            response()->json($response);
    }

    public function StatSum(StatSumRequest $request) {
        $response = [];
        $games    = Game::ofCharacterName($request->input("name"))
                        ->ofUser($request->user()->id)
                        ->get();
        foreach (Game::STATS as $stat) {
            $response[$stat] = $games->pluck($stat)->sum();
        }
        return ($request->input("stat"))
            ?
            response()->json($response[$request->input("stat")])
            :
            response()->json($response);
    }
}
