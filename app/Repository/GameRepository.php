<?php

namespace App\Repository;

use App\Game;
use Carbon\Carbon;

class GameRepository {

    CONST CACHE_KEY = 'GAMES';
    
    public function getGames() {

      $cacheKey = 'all';
      $key = $this->getCacheKey($cacheKey);

      $gameModel = new Game();

      $games = cache()->remember($cacheKey, Carbon::now()->addMinutes(5), function() use($gameModel) {
        return $gameModel->get();
      });

      $response = [];

      foreach($games as $game) {

        $gameUsers = [];

        foreach ($game->score as $score) {
          $gameUsers[] = $score->user_id;
        };

        $uniqueUsers = collect($gameUsers)->unique()->values()->all();
        $total_play_count = count($uniqueUsers);

        $response[] = [
          'id' => $game->id,
          'title' => $game->title,
          'unique_users' => $uniqueUsers,
          'total_play_count' => $total_play_count
        ];
      }

      return $response;
    }

    public function getCacheKey($key) {
        $key = strtoupper($key);

        return self::CACHE_KEY .".$key";
    }
}