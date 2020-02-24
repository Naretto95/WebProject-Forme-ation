<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchFormRequest;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $domains = [
            "Secourisme",
            "Coaching",
            "Natation",
            "Educateur",
            "Sport collectif",
            "Sport individuel",
            "Forme"
        ];
        $regions = [
            "Auvergne-Rhône-Alpes",
            "Bourgogne-Franche-Comté",
            "Bretagne",
            "Centre-Val de Loire",
            "Corse",
            "Grand Est",
            "Hauts-de-France",
            "Île-de-France",
            "Normandie",
            "Nouvelle-Aquitaine",
            "Occitanie",
            "Pays de la Loire",
            "Provence-Alpes-Côte d’Azur",
        ];

        return view('pages.home', compact('regions', 'domains'));
    }

    public function search(ResearchFormRequest $request){
        $regions = [
            ["Auvergne-Rhône-Alpes",[45.5158333, 4.538055555555555], [1,3,7,15,26,38,42,43,63,69,73,74]],
            ["Bourgogne-Franche-Comté",[47.2352778, 4.809166666666666], [21,25,39,58,70,71,89,90]],
            ["Bretagne",[48.1797222, -2.838611111111111], [29,35,45,62]],
            ["Centre-Val de Loire",[47.4805556, 1.6852777777777779], [18,28,36,37,41,45]],
            ["Corse",[42.1497222, 9.105277777777777], [96, 97]],
            ["Grand Est",[48.6891667, 5.619444444444445], [8,10,51,52,54,55,57,67,68,88]],
            ["Hauts-de-France",[49.9661111, 2.7752777777777777], [2,59,60,62,80]],
            ["Île-de-France",[48.7091667, 2.504722222222222], [75,77,78,91,92,93,94,95]],
            ["Normandie",[49.1211111, 0.10666666666666667], [14,27,50,61,76]],
            ["Nouvelle-Aquitaine",[45.1922222, 0.19777777777777777], [16,17,19,23,24,33,40,47,64,79,86,87]],
            ["Occitanie",[43.7022222, 2.1372222222222224], [9,11,12,30,31,32,34,46,48,65,66,81,82]],
            ["Pays de la Loire",[47.4747222, -0.8238888888888889], [44,49,53,72,85]],
            ["Provence-Alpes-Côte d’Azur",[43.955, 6.053333333333333], [4,5,6,13,83,84]]
        ];
        
        $trainings = Training::where('domain', $request->domain)->where(function ($query){
            global $request;
            if(!empty($request->diploma)){
                $query->where('diploma', $request->diploma);
            }
            
        })->where(function ($query){
            global $request;
            if(!empty($request->region)){
                $query->where('region', $request->region);
            }else{
                $query->where('region', 'Île-de-France');
            }
        })->where(function ($query){
            global $request;
            if(!empty($request->department)){
                $query->where('department', $request->department);
            }
        })->where(function ($query){
            if(!auth()->check()){
                $query->where('verificated', '1');
            }
        })->paginate(10);

        if(!empty($request->region)){
            foreach($regions as $region) {
                if ($request->region == $region[0]) {
                    $zoomCoord = $region[1];
                }
            }

        }elseif(!empty($request->department)) {
            foreach($regions as $region) {
                if (in_array($request->department, $region[2])) {
                    $zoomCoord = $region[1];
                }
            }
        }else{
            $zoomCoord = $regions[7][1];
        }

        return view('trainings.index', compact('trainings', 'zoomCoord'));
    }

    public function auto_complete(Request $request)
    {
        
        $diplomas = Training::whereRaw('upper(diploma) LIKE upper(?)', ["%{$request->diploma}%"])->where(function ($query){
            global $request;
            if(!empty($request->domain)){
                $query->where('domain', $request->domain);
            }
        })->distinct()->get(['diploma']);
        $msg = "";
        for ($i=0; $i < count($diplomas); $i++) { 
            $msg .= $diplomas[$i]->diploma . "|";
        }
        return $msg;
        
        
        
    }
}
