<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Http\Requests\GameValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class GameController extends Controller
{
    public function getAllGames() {
        $games = Game::orderBy('title')->get();

        $response = new Collection();

        foreach ($games as $game) {
            $categories = new Collection();
            foreach ($game->categories as $category) {
                $cat = new Collection();

                $cat->put('id', $category->id);
                $cat->put('name', $category->name);

                $categories->push($cat);
            }
            $item = new Collection();
            $item->put('id', $game->id);
            $item->put('title', $game->title);
            $item->put('grade', $game->grade);
            $item->put('description', $game->description);
            $item->put('parentalRating', $game->parental_rating);
            $item->put('cover', $game->cover);
            $item->put('categories', $categories);

            $response->push($item);
        }

        return $response;
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

    public function editGameCategories(Request $request) {
//        try {
            $game = Game::find($request['gameId']);

            $game->categories()->detach();

            $game->categories()->attach($request['selectedCategories']);

            return 'edited';
//        } catch (\Exception $exception) {
//            return 'failed';
//        }
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
