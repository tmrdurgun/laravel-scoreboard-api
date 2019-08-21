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

    public function add_score(Request $request)
    {

        $response = [];
        
        $data = $request->json()->all();

        $game_id = $data['game_id'];
        $user_id = $data['user_id'];
        $score = $data['score'];

        $scoreModel = new Score();

        $fields = [
            'game_id' => $game_id,
            'user_id' => $user_id
        ];

        $score = $scoreModel->where($fields)->first();

        $user = $score->user;

            $response[] = [
                'user' => $user,
                'old_rank' => $score->old_rank,
                'new_rank' => $score->new_rank,
                'sweep' => [1,2,3]
            ];

        return $response;
    }
}
