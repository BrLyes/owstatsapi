<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatAverageRequest;
use App\Http\Requests\StatOvertimeRequest;
use App\Http\Requests\StatCharRequest;
use App\Http\Requests\StatSumRequest;
use App\Models\Character;
use App\Models\Stat;

class StatController extends Controller
{
    public function getChars() {
        return response()->json(Character::all());
    }

    //TODO: paginate this
    public function statsForChar(StatCharRequest $request) {
        return response()->json(Character::where("name", $request->input("name"))->first()->stats);
    }

    public function StatOverTime(StatOvertimeRequest $request) {
        $character = Character::where("name", $request->input("name"))->first();
        $stats     = Stat::where("character_id", $character->id)
                         ->select($request->input("stat"), "match_date")
                         ->orderBy("match_date")
                         ->whereBetween("match_date", [
                             $request->input("after"), $request->input("before")
                         ])->get();

        return response()->json($stats);
    }

    public function StatAverage(StatAverageRequest $request) {
        $data  = [];
        $stats = Character::where("name", $request->input("name"))->first()->stats;
        foreach (Stat::STATS as $stat) {
            $data[$stat] = number_format($stats->pluck($stat)->average(),2);
        }
        return ($request->input("stat")) ?
            response()->json($data[$request->input("stat")]) :
            response()->json($data);
    }

    public function StatSum(StatSumRequest $request) {
        $data  = [];
        $stats = Character::where("name", $request->input("name"))->first()->stats;
        foreach (Stat::STATS as $stat) {
            $data[$stat] = $stats->pluck($stat)->sum();
        }
        return ($request->input("stat")) ?
            response()->json($data[$request->input("stat")]) :
            response()->json($data);
    }
}
