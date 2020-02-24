@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="container">
    <h1>Tableau de bord</h1>
    @forelse($participants as $participant)
    <p><a href="{{ route('participants.show', $participant) }}">{{ sprintf('%s %s', $participant->firstname, $participant->lastname)  }}</a></p>
    <hr>
    @empty
    <p>Aucune inscription non traitée...</p>
    @endforelse

</div>
@endsection
