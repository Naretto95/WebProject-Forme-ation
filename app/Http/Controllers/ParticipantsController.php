<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantFormRequest;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participants = Participant::leftJoin('trainings', 'trainings.id', '=', 'participants.training_id')->leftJoin('users', 'users.id', '=', 'trainings.user_id')->where('participants.verificated', '0')->where(function ($query){
            if(isUser(auth()->user())){
                $query->where('users.id', auth()->user()->id);
            }
        })->paginate(10);
        return view('pages.dashboard', compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticipantFormRequest $request)
    {
        $participant = Participant::create($request->only('lastname', 'firstname', 'birthday', 'email', 'address', 'training_id'));

        $path = request('deposit')->store('file_deposit', 'public');
        $participant->deposit = $path;
        $participant->save();
        flash('Inscription enregistrée!');

        return Redirect::home();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Participant $participant)
    {
        $count = Participant::leftJoin('trainings', 'trainings.id', '=', 'participants.training_id')->leftJoin('users', 'users.id', '=', 'trainings.user_id')->where('users.id', auth()->user()->id)->count();
        if(isUser(auth()->user()) && $count == 0){
            flash("Accès refusé!", "danger");
            return Redirect::route('dashboard');
        }
        return view('participants.show', compact('participant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participant $participant)
    {
        $count = Participant::leftJoin('trainings', 'trainings.id', '=', 'participants.training_id')->leftJoin('users', 'users.id', '=', 'trainings.user_id')->where('users.id', auth()->user()->id)->count();
        if(isUser(auth()->user()) && $count == 0){
            flash("Accès refusé!", "danger");
            return Redirect::route('dashboard');
        }
        $participant->update([
            'verificated' => '1',
        ]);

        flash(sprintf('Inscription de %s %s traitée!', $participant->firstname , $participant->lastname), 'info');

        return Redirect::route('participants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'])->only('index', 'show', 'update');
    }
}
