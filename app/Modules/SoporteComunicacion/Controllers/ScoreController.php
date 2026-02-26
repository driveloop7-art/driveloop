<?php

namespace App\Modules\SoporteComunicacion\Controllers;

use App\Modules\SoporteComunicacion\Models\Score;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'codtic' => 'required|string|max:10',
            'questions' => 'required|array',
        ]);

        $codtic = $data['codtic'];

        foreach ($data['questions'] as $question_id => $score) {
            $question = new Score();
            $question->codtic = $codtic;
            $question->idques = intval($question_id);
            $question->score = intval($score);
            $question->save();
        }

        return redirect()->route('dashboard')->with('message', "Encuesta enviada correctamente para el ticket {$codtic}");
    }
}