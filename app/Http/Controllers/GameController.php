<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Http\Requests\GameValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function getAllGames() {
        return Game::orderBy('title')->get();
    }

    public function addNewGame(Request $request) {
        return Game::create([
            'title' => $request['title'],
            'parental_rating' => $request['parentalRating'],
            'cover' => $request['cover'],
            'description' => $request['description'],
            'grade' => 0
        ]);
    }

    public function editGame(Request $request) {
        try {
            $game = Game::find($request['game']);

            $game->update([
                'title' => $request['newTitle'],
                'cover' => $request['newCover'],
                'parental_rating' => $request['newParentalRating'],
                'description' => $request['newDescription'],
            ]);

            return $game;
        } catch (\Exception $exception) {
            return 'failed';
        }
    }

    public function deleteGame(Request $request) {
        $game = Game::find($request['game']);
        $game->delete();

        return 'deleted';
    }

    public function loadCover(Request $request)
    {
        $image = $request['image'];

        $exploded = explode(',', $image);

        if (str_contains($exploded[0], 'png')) {
            $extension = 'png';
        } else if (str_contains($exploded[0], 'jpg')) {
            $extension = 'jpg';
        } else if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        } else {
            return 'invalidExtension';
        }

        $decode = base64_decode($exploded[1]);

        $filename = Str::random(10) . '.' . $extension;

        $path = public_path() . '/images/covers/' . $filename;

        file_put_contents($path, $decode);

        return $filename;
    }
}
