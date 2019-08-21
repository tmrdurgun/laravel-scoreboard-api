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

        $scoreModel = new Score();
        
        $data = $request->json()->all();

        $game_id = $data['game_id'];
        $user_id = $data['user_id'];
        $score = $data['score'];

        $scoreData = $this->getScore($game_id, $user_id);

        // Rank before new score
        $max_score = json_decode($this->getMaxScore($game_id, $user_id));
        $old_score = $max_score->score;
        $new_score = $old_score + $score;

        $old_rank = $this->getRank($game_id, $user_id);
        
        try {
            $update = $scoreModel->where([ 'id' => $max_score->id, 'game_id' => $game_id, 'user_id' => $user_id])->update(['score' => $new_score]);

            $new_rank = $this->getRank($game_id, $user_id);
    
            $sweepList = $this->sweepList($new_score);

            $response[] = [
                'status' => 1,
                'user' => $scoreData->user,
                'old_rank' => $old_rank,
                'new_rank' => $new_rank,
                'sweep' => $sweepList
            ];
        } catch (\Exception $e) {
            $response[] = [
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }        

        return $response;
    }

    public function getMaxScore($game_id, $user_id) {
        $scoreModel = new Score();

        $scoreList = $scoreModel->orderBy('score', 'desc')->get();
        
        $scoreList->map(function ($item, $key) {
            return $item->rank = $key + 1;
        });

        $userScores = collect( $scoreList->filter(function($item) use($user_id, $game_id) {
            return $item->game_id == (int)$game_id && $item->user_id == (int)$user_id;
        })->toArray());

        $userMaxScore = $userScores->where('score', $userScores->max('score'))->first();
        
        return collect($userMaxScore)->toJson();
    }

    public function getRank($game_id, $user_id) {
        $max_score = json_decode($this->getMaxScore($game_id, $user_id));
        return $max_score->rank;
    }

    public function getScore($game_id, $user_id){
        $scoreModel = new Score();

        $where = [
            'game_id' => $game_id,
            'user_id' => $user_id
        ];

        $score = $scoreModel->where($where)->first();

        return $score;
    }

    public function getScores() {
        $scoreModel = new Score();

        return $scoreModel->all()->orderBy('score', 'desc');
    }

    public function sweepList($score) {
        $scoreModel = new Score();

        $scoreList = $scoreModel->orderBy('score', 'desc')->get();

        $sweepList = [];
        
        foreach ($scoreList as $item) {
            $max_score = json_decode($this->getMaxScore($item->game_id, $item->user_id));

            if((int)$max_score->score < (int)$score) {
                $sweepList[] = $max_score->user_id;
            };
        }

        $sweepList = collect($sweepList)->unique()->values()->all();

        return $sweepList;
    }

}
