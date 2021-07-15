<?php

namespace App\Http\Controllers;

use App\AudioVisual;
use App\Evaluation;
use App\Game;
use App\GameMechanic;
use App\Http\Requests\EvaluationValidation;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function getAllEvaluations(Request $request)
    {
        $evaluations = Evaluation::orderBy('title')->get();

        $response = new Collection();

        foreach ($evaluations as $evaluation) {
            $gm = $evaluation->gameMechanic;
            $st = $evaluation->story;
            $av = $evaluation->audioVisual;

            $item = new \stdClass();
            $item->id = $evaluation->id;
            $item->title = $evaluation->title;
            $item->grade = $evaluation->grade;
            $item->description = $evaluation->description;
            $item->objective = $gm->objective_grade;
            $item->challenge = $gm->challenge_grade;
            $item->rule = $gm->rule_grade;
            $item->control = $gm->control_grade;
            $item->scenario = $st->scenario_grade;
            $item->characterBuilding = $st->character_building_grade;
            $item->plot = $st->plot_grade;
            $item->graphic = $av->graphic_grade;
            $item->audio = $av->audio_grade;
            $item->gameTitle = $evaluation->game->title;
            $item->userId = $evaluation->user->id;

            $response->push($item);
        }

        return $response;
    }

    public function addNewEvaluation(Request $request)
    {
        $total = $request['objective'] + $request['challenge'] + $request['rule']
            + $request['control'] + $request['scenario'] + $request['characterBuilding']
            + $request['plot'] + $request['graphic'] + $request['audio'];

        $grade = $total / 9;

        $evaluation = Evaluation::create([
            'user_id' => Auth::id(),
            'game_id' => $request['gameId'],
            'title' => $request['title'],
            'description' => $request['description'],
            'grade' => round($grade)
        ]);

        GameMechanic::create([
            'evaluation_id' => $evaluation->id,
            'objective_grade' => $request['objective'],
            'challenge_grade' => $request['challenge'],
            'rule_grade' => $request['rule'],
            'control_grade' => $request['control'],
        ]);

        Story::create([
            'evaluation_id' => $evaluation->id,
            'scenario_grade' => $request['scenario'],
            'character_building_grade' => $request['characterBuilding'],
            'plot_grade' => $request['plot'],
        ]);

        AudioVisual::create([
            'evaluation_id' => $evaluation->id,
            'graphic_grade' => $request['graphic'],
            'audio_grade' => $request['audio'],
        ]);

        $game = Game::find($request['gameId']);
        $gameEvaluations = $game->evaluations;
        $gameGrade = 0;
        foreach ($gameEvaluations as $gameEvaluation) {
            $gameGrade += $gameEvaluation->grade;
        }
        $gameGrade = $gameGrade / $gameEvaluations->count();
        $game->update([
            'grade' => $gameGrade
        ]);

        return 'evaluated';
    }

    public function editEvaluation(Request $request)
    {
        try {
            $total = $request['objective'] + $request['challenge'] + $request['rule']
                + $request['control'] + $request['scenario'] + $request['characterBuilding']
                + $request['plot'] + $request['graphic'] + $request['audio'];

            $grade = $total / 9;

            $evaluation = Evaluation::find($request['evaluationId']);

            $evaluation->update([
                'title' => $request['title'],
                'description' => $request['description'],
                'grade' => round($grade)
            ]);

            $evaluation->gameMechanic->update([
                'objective_grade' => $request['objective'],
                'challenge_grade' => $request['challenge'],
                'rule_grade' => $request['rule'],
                'control_grade' => $request['control'],
            ]);

            $evaluation->story->update([
                'scenario_grade' => $request['scenario'],
                'character_building_grade' => $request['characterBuilding'],
                'plot_grade' => $request['plot'],
            ]);

            $evaluation->audioVisual->update([
                'graphic_grade' => $request['graphic'],
                'audio_grade' => $request['audio'],
            ]);

            $game = $evaluation->game;
            $gameEvaluations = $game->evaluations;
            $gameGrade = 0;
            foreach ($gameEvaluations as $gameEvaluation) {
                $gameGrade += $gameEvaluation->grade;
            }
            $gameGrade = $gameGrade / $gameEvaluations->count();
            $game->update([
                'grade' => $gameGrade
            ]);

            $gm = $evaluation->gameMechanic;
            $st = $evaluation->story;
            $av = $evaluation->audioVisual;

            $item = new Collection();
            $item->put('id', $evaluation->id);
            $item->put('title', $evaluation->title);
            $item->put('grade', $evaluation->grade);
            $item->put('description', $evaluation->description);
            $item->put('objective', $gm->objective_grade);
            $item->put('challenge', $gm->challenge_grade);
            $item->put('rule', $gm->rule_grade);
            $item->put('control', $gm->control_grade);
            $item->put('scenario', $st->scenario_grade);
            $item->put('characterBuilding', $st->character_building_grade);
            $item->put('plot', $st->plot_grade);
            $item->put('graphic', $av->graphic_grade);
            $item->put('audio', $av->audio_grade);
            $item->put('gameTitle', $evaluation->game->title);
            $item->put('userId', $evaluation->user->id);

            return $item;
        } catch (\Exception $exception) {
            return 'failed';
        }
    }

    public function deleteEvaluation(Request $request) {
        $evaluation = Evaluation::find($request['evaluation']);

        $game = $evaluation->game;

        $evaluation->delete();

        $gameEvaluations = $game->evaluations;
        $gameGrade = 0;
        foreach ($gameEvaluations as $gameEvaluation) {
            $gameGrade += $gameEvaluation->grade;
        }
        if ($gameEvaluations->count())
            $gameGrade = $gameGrade / $gameEvaluations->count();
        $game->update([
            'grade' => $gameGrade
        ]);

        return 'deleted';
    }
}
