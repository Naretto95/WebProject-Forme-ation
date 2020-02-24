@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<h1 class="text-center">Modifier l'utilisateur {{ $user->name }}</h1>
	
		<form action="{{ route('users.update', $user) }}" method="POST" novalidate="">
			@csrf
			@method('PUT')
						
            <div class="form-group col-md-6 offset-md-3">
                <label for="name" class="control-label sr-only">Nom</label>
                <input type="text" id="name" name="name" placeholder="Nom" value="{{ old('name') ?: $user->name }}" class="form-control @error('name') is-invalid @enderror" required>
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6 offset-md-3">
                <label for="email" class="control-label sr-only">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') ?: $user->email }}" class="form-control @error('email') is-invalid @enderror" required>
                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
            </div> 

            <div class="form-group col-md-6 offset-md-3">
                <label for="password" class="control-label sr-only">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Mot de passe" class="form-control @error('password') is-invalid @enderror">
                {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
            </div> 

            <div class="form-group col-md-6 offset-md-3">
                <label for="password_confirmation" class="control-label sr-only">Confirmation mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmation mot de passe" class="form-control @error('password_confirmation') is-invalid @enderror">
                {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</div>') !!}
            </div> 
            
            <div class="form-group col-md-6 offset-md-3">
                @if(!isSuperAdmin($user))
                <label for="status" class="control-label sr-only">Statut</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="user" {{ set_selected('user', old('status') ?: $user->status) }}>Utilisateur</option>
                    <option value="admin" {{ set_selected('admin', old('status') ?: $user->status) }}>Administrateur</option>
                </select>
                {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
                 @else
                    <strong>SUPER ADMIN</strong>
                @endif
            </div>
           

	        <div class="form-group col-md-6 offset-md-3">
	            <input type="submit" value="Modifier" class="btn btn-primary btn-block">
	        </div>
		</form>

		<p><a href="{{ route('users.index') }}">Annuler</a></p>
	</div>
@stop