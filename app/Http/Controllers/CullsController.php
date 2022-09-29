<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class CullsController extends Controller
{
    public function home(Request $request)
    {
        $randCulls = generate_num();
        $request->session()->put('randCulls', $randCulls);
        $request->session()->put('score', 10000);
        return view('home');
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
        if ($culls['bulls'] == 4) {
            $message = "<br/><br/><h3>Correct! You guessed the number: " . implode("", $randCulls) . " Your score: " . $score . "</h3>";
            $request->session()->forget('randCulls');
            return response()->json(['success' => $message, 'culls' => $culls, 'score' => $score]);
        } else {
            $message = "<br/>" . $userCulls . " Result: " . "Bulls:" . $culls['bulls'] . " " . "Cows:" . $culls['cows'];
            $request->session()->put('score', $score - 250);
            return response()->json(['success' => $message, 'culls' => $culls]);
        }

    }

    public function createScore(Request $request)
    {

        $score = $request->session()->get('score');
        $request->validate([
            'name' => 'required',
            'score' => 'required',
        ]);
        if ($request->score != $score) {
            return Redirect::back()->withErrors(['error' => 'Score submitted is different than actual score.']);
        }
        $newScore = Score::create([
            'name' => $request->name,
            'score' => $request->score,
        ]);
        if ($newScore) {
            $request->session()->forget('score');
            $request->session()->flash('message', "Successfully submitted your score!");
        }
        return redirect()->back();
    }

    public function getScores(Request $request)
    {
        if ($request->ajax()) {
            $scores = Score::orderBy('score', 'DESC')->limit(10)->get();
            return Datatables::of($scores)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
