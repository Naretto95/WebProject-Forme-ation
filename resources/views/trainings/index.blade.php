@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<h1>{{  $trainings->total() }} {{ Str::plural('Formation', $trainings->total()) }}</h1>
		<div id="map"></div>
		<ul>
			@forelse($trainings as $training)
				<li><a href="{{ route('trainings.show', $training)}}">{{ $training->name }}</a></li>
			@empty
				<p>Aucune formation pour le moment...</p>
			@endforelse
		</ul>
		{{ $trainings->links() }}
	</div>
@stop

@section('scripts')
	
   <script type="text/javascript">
       var map = L.map('map').setView([{{ $zoomCoord[0] }}, {{ $zoomCoord[1] }}], 8.5);
       L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(map);

       var redIcon = new L.Icon({
		  iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
		  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
		  iconSize: [25, 41],
		  iconAnchor: [12, 41],
		  popupAnchor: [1, -34],
		  shadowSize: [41, 41]
		});


		@foreach ($trainings as $training)
         	var marker = L.marker([{{ $training->Ncoord }}, {{ $training->Ecoord }}], {icon: redIcon}).addTo(map);
			marker.bindPopup("<a href=\'{{ route('trainings.show', $training)}}\'><b>{{ $training->name}}</b></a><br>{{ $training->cost . '€'}}<br>{{ 'Le ' . date('d/m/Y', strtotime($training->date)) }}<br>{{ 'De ' . date('H:i', strtotime($training->start)) .' à ' . date('H:i', strtotime($training->end)) }}");
   		 @endforeach


   		
       	
       
    </script>
@stop