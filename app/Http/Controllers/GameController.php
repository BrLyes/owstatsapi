<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Http\Requests\RequiresCharacterNameRequest;
use App\Http\Requests\StatAverageRequest;
use App\Http\Requests\StatOvertimeRequest;
use App\Http\Requests\StatCharRequest;
use App\Http\Requests\StatSumRequest;
use App\Models\Character;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
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

    public function GamesByChar(){
        return response()->json(Game::select(DB::raw("character_id, count(*) as total"))
                     ->ofUser(Auth()->user()->id)
                     ->with("character")
                     ->groupBy("character_id")
                     ->orderBy("total", "desc")
                     ->get());
    }

    public function store(GameStoreRequest $request) {
        $character = Character::where("name", $request->input("name"))->first();
        return response()->json(Game::create(
            [
                "kill"         => $request->input("kill"),
                "death"        => $request->input("death"),
                "assist"       => $request->input("assist"),
                "damage"       => $request->input("damage"),
                "heal"         => $request->input("heal"),
                "mitigate"     => $request->input("mitigate"),
                "user_id"      => $request->user()->id,
                "character_id" => $character->id,
                "match_date"   => $request->input("match_date"),
            ],
        ));
    }

    public function lifetimeStats(RequiresCharacterNameRequest $request){
        $games               = Game::with('character')
                                   ->ofUser(Auth()->user()->id)
                                   ->ofCharacterName($request->input("name"))
                                   ->get();

        foreach (Game::STATS as $stat) {
            $arrResponse[$stat] = $games->pluck($stat)->sum();
        }
        $arrResponse["games"]     = $games->count();
        $arrResponse["character"] = $games->first()->character;

        return response()->json($arrResponse);
    }
}
