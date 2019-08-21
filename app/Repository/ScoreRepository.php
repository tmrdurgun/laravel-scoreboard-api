<?php

namespace App\Repository;

use App\Score;
use App\Game;
use App\User;
use Carbon\Carbon;

class ScoreRepository {

    CONST CACHE_KEY = 'SCORE';
    
    public function GetScoreboard($game_id)
    {

        $response = [];
        
        $gameModel = new Game();
        $game = $gameModel->where('id', $game_id)->first();

        $scores = collect($game->score)->sortByDesc('score')->unique('user')->values()->all();

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

    public function AddScore($game_id, $user_id, $score)
    {
        $response = [];

        $scoreModel = new Score();

        $scoreData = $this->GetScore($game_id, $user_id);

        // Rank before new score
        $max_score = json_decode($this->GetMaxScore($game_id, $user_id));
        $old_score = $max_score->score;
        $new_score = $old_score + $score;

        $old_rank = $this->GetRank($game_id, $user_id);
        
        try {
            $update = $scoreModel->where([ 'id' => $max_score->id, 'game_id' => $game_id, 'user_id' => $user_id])->update(['score' => $new_score]);

            $new_rank = $this->GetRank($game_id, $user_id);
    
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

    public function GetMaxScore($game_id, $user_id) {
        $scoreModel = new Score();

        $scoreList = $this->GetScores();
        
        $scoreList->map(function ($item, $key) {
            return $item->rank = $key + 1;
        });

        $userScores = collect( $scoreList->filter(function($item) use($user_id, $game_id) {
            return $item->game_id == (int)$game_id && $item->user_id == (int)$user_id;
        })->toArray());

        $userMaxScore = $userScores->where('score', $userScores->max('score'))->first();
        
        return collect($userMaxScore)->toJson();
    }

    public function GetRank($game_id, $user_id) {
        $max_score = json_decode($this->GetMaxScore($game_id, $user_id));
        return $max_score->rank;
    }

    public function GetScore($game_id, $user_id){
        $scoreModel = new Score();

        $where = [
            'game_id' => $game_id,
            'user_id' => $user_id
        ];

        $score = $scoreModel->where($where)->first();

        return $score;
    }

    public function GetScores() {
        $scoreModel = new Score();

        $scoreList = $scoreModel->orderBy('score', 'desc')->get();

        return $scoreList;
    }

    public function SweepList($score) {
        $scoreModel = new Score();

        $scoreList = $this->GetScores();

        $sweepList = [];
        
        foreach ($scoreList as $item) {
            $max_score = json_decode($this->GetMaxScore($item->game_id, $item->user_id));

            if((int)$max_score->score < (int)$score) {
                $sweepList[] = $max_score->user_id;
            };
        }

        $sweepList = collect($sweepList)->unique()->values()->all();

        return $sweepList;
    }

    public function GetCacheKey($key) {
        $key = strtoupper($key);

        return self::CACHE_KEY .".$key";
    }
}