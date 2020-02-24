@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="container">
    <h1>{{ sprintf('%s %s', $participant->firstname, $participant->lastname) }}

    @if($participant->verificated == 0)
    <a class="btn btn-success" title="Valider" href="{{ route('participants.update', $participant) }}" onclick="event.preventDefault();document.getElementById('verificate-form').submit();"><i class="fa fa-check"></i></a> 

    <form id="verificate-form" action="{{ route('participants.update', $participant) }}" method="POST" style="display: none;">
        @csrf
        @method('PUT')
	</form>
	@endif
	</h1>
	<p>{{ date('d/m/Y', strtotime($participant->birthday)) }}</p>
	<p>{{ $participant->email }}</p>
	<p>{{ $participant->address }}</p>
	<a href="/storage/{{ $participant->deposit }}" target="_blank">Fichiers</a>
</div>
@endsection
