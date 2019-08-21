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

        $scores = collect($game->score)->sortByDesc('score');

        $limit = 25;
        $i = 0;

        foreach ($scores as $key => $value) {

            if($i < $limit){
                $user = $value->user;

                $response[] = [
                    'user' => $user,
                    'score' => $value->score,
                    'rank' => $i + 1
                ];
            }
            
            $i++;
        }

        return $response;
    }
}
