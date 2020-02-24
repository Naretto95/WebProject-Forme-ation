<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchFormRequest;
use App\Http\Requests\TrainingFormRequest;
use App\Mail\TrainingCreated;
use App\Models\Participant;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class TrainingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = Training::where(function ($query){
            if(!isAdmin(auth()->user())){
                $query->where('verificated', '1');
            }
        })->paginate(10);
        $zoomCoord = [48.7091667, 2.504722222222222];
        
        return view('trainings.index', compact('trainings', 'zoomCoord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $training = new Training;
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
        return view('trainings.create', compact('training', 'regions', 'domains'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingFormRequest $request)
    {
        $training = Training::create($request->only('email', 'name', 'domain', 'diploma', 'cost', 'date', 'start', 'end', 'duration', 'location', 'Ncoord', 'Ecoord', 'region', 'department', 'description', 'funding', 'prospect'));

        if (Auth::check()) {
            $training->user_id = Auth::user()->id;
            $training->verificated = '1';
            $training->save();
        }

        Mail::to($training->email)->send(new TrainingCreated($training));

        flash('Formation créée!');

        return Redirect::home();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        if ($training->verificated == 0 && !isAdmin(auth()->user())) {
            flash('Accès refusé!', 'danger');
            return Redirect::home();
        }
        $participant = new Participant;
        return view('trainings.show', compact('training', 'participant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        if ($training->user_id && $training->user_id != Auth::user()->id) {
            flash("Accès refusé!", "danger");
            return Redirect::home();
        }
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
        return view('trainings.edit', compact('training', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrainingFormRequest $request, Training $training)
    {
        $training->update($request->only('email', 'name', 'domain', 'diploma', 'cost', 'date', 'start', 'end', 'duration', 'location', 'Ncoord', 'Ecoord', 'region', 'department', 'description', 'funding', 'prospect'));

        flash(sprintf('Formation "%s" modifiée!', $training->name), 'info');

        return Redirect::route('trainings.show', $training);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $training->delete();

        flash(sprintf('Formation "%s" supprimée!', $training->name), 'danger');

        return Redirect::route('dashboard');
    }

    public function published(Training $training)
    {
        $training->update([
            'verificated' => $training->verificated == '0' ? '1' : '0',
        ]);

        if ($training->verificated == '1') {
            flash(sprintf('Formation "%s" publiée!', $training->name), 'info');
        }else{
            flash(sprintf('Formation "%s" masquée!', $training->name), 'info');
        }
        

        return Redirect::route('trainings.show', $training);   
    }

    public function auto_complete(Request $request)
    {
        $des = DB::table('auto_description')->whereRaw('upper(diploma) = upper(?)', $request->diploma)->first();
        if ($des) {
            return $des->description ."|". $des->funding ."|". $des->prospect;
        }else{
            $diplomas = DB::table('auto_description')->whereRaw('upper(diploma) LIKE upper(?)', ["%{$request->diploma}%"])->get();
            $msg = "!!!|";
            for ($i=0; $i < count($diplomas); $i++) { 
                $msg .= $diplomas[$i]->diploma . "|";
            }
            return $msg;
        }
        
        
    }

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['destroy', 'published', 'edit', 'update']], 'admin', ['only' => ['destroy', 'published']]);
    }
}
