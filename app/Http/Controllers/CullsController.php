<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class CullsController extends Controller
{
    public function home(Request $request){
        $randCulls = generate_num();
        $request->session()->put('randCulls', $randCulls);
        $request->session()->put('score', 10000);
        $scores = Score::orderBy('score','DESC')->limit(10)->get();
        return view('home', ['scores'=>$scores]);
    }

    public function getCulls(Request $request)
    {
        $request->validate([
            'culls' => 'required|numeric|digits:4|dupes',
        ]);
        $userCulls = $request->culls;
        $randCulls = $request->session()->get('randCulls');
        $culls = getCulls($userCulls, $randCulls);
        $score = $request->session()->get('score');
        $message = '';
        if($culls['bulls'] == 4){
            $message = "<br/>You guessed the number: " . implode("", $randCulls). " Your score: " . $score;
            $request->session()->forget('score');
            $request->session()->forget('randCulls');
            return response()->json(['success'=>$message, 'culls'=>$culls, 'score'=> $score]);
        } else {
            $message = "<br/>" . $userCulls . " Result: " . "Bulls:" . $culls['bulls']. " " . "Cows:" . $culls['cows'] . " " . implode("", $randCulls);
            $request->session()->put('score', $score-250);
            return response()->json(['success'=>$message, 'culls'=>$culls]);
        }
 
    }

    public function createScore(Request $request){
        $request->validate([
            'name' => 'required',
            'score' => 'required'
        ]);

        Score::create([
            'name'=>$request->name,
            'score'=>$request->score
        ]);
        return redirect()->back();
    }
}
