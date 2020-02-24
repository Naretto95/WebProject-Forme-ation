@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>{{  $users->total() }} {{ Str::plural('Utilisateur', $users->total()) }} <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i></a></h1>
		<ul>
			@forelse($users as $user)
				<li><a href="{{ route('users.edit', $user)}}">{{ $user->name }}</a></li>
			@empty
				<p>Aucun utilisateur pour le moment...</p>
			@endforelse
		</ul>
		{{ $users->links() }}
	</div>
@stop