<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Score;
use App\Game;
use App\User;

class ScoreController extends Controller
{
    public function get_scoreboard(Request $request)
    {

        $response = [];

        $data = $request->json()->all();

        $game_id = $data['game_id'];

        $gameModel = new Game();
        $game = $gameModel->where('id', $game_id)->first();

        $scores = $game->score;

        foreach ($scores as $key => $value) {
            $user = User::where('id', $value->user_id)->first();

            // $user = Score::with('user')->get();

            $response[] = [
                'user_id' => $value->user_id,
                'score' => $value->score,
                'user_details' => $user
            ];
        }

        return $response;
    }
}
