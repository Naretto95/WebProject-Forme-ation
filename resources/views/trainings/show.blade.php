@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>{{ $training->name }}</h1>
		<p>
			<p>{{ $training->domain }}</p>
			<p>{{ $training->diploma }}</p>
			<p>{{ $training->cost . '€' }}</p>
			<p>{{ 'Le ' . date('d/m/Y', strtotime($training->date)) }}</p>
			<p>{{ 'De ' . date('H:i', strtotime($training->start)) . ' à ' . date('H:i', strtotime($training->end)) }}</p>
			<p>{{ $training->location }}</p>
			<p>{{ $training->region }}</p>
			<p>{{ $training->department }}</p>
			<p>{{ $training->description }}</p>
			<p>{{ $training->funding }}</p>
			<p>{{ $training->prospect }}</p>
		</p>
		@if(isAdmin(auth()->user()))
			@if($training->verificated == 0)
			<a class="btn btn-light" href="{{ route('trainings.published', $training) }}" onclick="event.preventDefault();document.getElementById('verificate-form').submit();"><i class="fa fa-check"></i> Publier</a> 
			@else
			<a class="btn btn-light" href="{{ route('trainings.published', $training) }}" onclick="event.preventDefault();document.getElementById('verificate-form').submit();"><i class="fa fa-check"></i> Masquer</a>
			@endif
            <form id="verificate-form" action="{{ route('trainings.published', $training) }}" method="POST" style="display: none;">
                @csrf
                @method('PUT')
            </form>
			
			<a class="btn btn-danger" href="{{ route('trainings.destroy', $training) }}" data-confirm="Etes-vous sûr?" data-method="DELETE"><i class="fa fa-trash"></i> Supprimer</a>
		@endif
		<hr>
		<p><a href="{{ route('trainings.index') }}">Toutes les formations</a></p>

		<h1>Inscription</h1>
		<form action="{{ route('participants.store') }}" method="POST" novalidate="" enctype="multipart/form-data">
			@csrf
			<div class="row">
	            <div class="form-group col-md-6">
	                <label for="lastname" class="control-label sr-only">Nom</label>
	                <input type="text" id="lastname" name="lastname" placeholder="Nom" value="{{ old('lastname') ?: $participant->lastname }}" class="form-control @error('lastname') is-invalid @enderror" required>
	                {!! $errors->first('lastname', '<div class="invalid-feedback">:message</div>') !!}
	            </div>
	            <div class="form-group col-md-6">
	                <label for="firstname" class="control-label sr-only">Prénom</label>
	                <input type="text" id="firstname" name="firstname" placeholder="Prénom" value="{{ old('firstname') ?: $participant->firstname }}" class="form-control @error('firstname') is-invalid @enderror" required>
	                {!! $errors->first('firstname', '<div class="invalid-feedback">:message</div>') !!}
	            </div>       
	        </div>
	        <div class="row">
	            <div class="form-group col-md-6">
	                <label for="birthday" class="control-label sr-only">Date de naissance</label>
	                <input type="date" id="birthday" name="birthday" placeholder="Date de naissance" value="{{ old('birthday') ?: $participant->birthday }}" class="form-control @error('birthday') is-invalid @enderror" required>
	                {!! $errors->first('birthday', '<div class="invalid-feedback">:message</div>') !!}
	            </div>
	            <div class="form-group col-md-6">
	                <label for="email" class="control-label sr-only">Email</label>
	                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') ?: $participant->email }}" class="form-control @error('email') is-invalid @enderror" required>
	                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
	            </div>       
	        </div>
	        <div class="row">
	        	<div class="form-group col-md-12">
	                <label for="address" class="control-label sr-only">Adresse</label>
	                <input type="text" id="address" name="address" placeholder="Adresse" value="{{ old('address') ?: $participant->address }}" class="form-control @error('address') is-invalid @enderror" required>
	                {!! $errors->first('address', '<div class="invalid-feedback">:message</div>') !!}
	            </div>
	        </div>
	        <div class="row">
	        	<div class="form-group col-md-12">
	                <label for="deposit" class="control-label sr-only">Formations antérieures, pré-requis</label>
	                <input type="file" id="deposit" name="deposit" placeholder="Formations antérieures, pré-requis" value="{{ old('deposit') ?: $participant->deposit }}" class="form-control @error('deposit') is-invalid @enderror" required>
	                {!! $errors->first('deposit', '<div class="invalid-feedback">:message</div>') !!}
	            </div>
	        </div>
	        <input type="hidden" name="training_id" value="{{ $training->id }}">
	        <div class="form-group">
	            <input type="submit" value="Créer" class="btn btn-primary btn-block">
	        </div>
	    </form>
	</div>
@stop