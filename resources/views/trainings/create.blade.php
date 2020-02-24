@extends('layouts.app', ['title' => 'Create'])

@section('content')
<div class="container">
    <h1>Créer une formation</h1>

    <form id="form" action="{{ route('trainings.store') }}" method="POST" novalidate="" autocomplete="off">
        @csrf 
        <div class="row">
            <div class="form-group col-md-6">
                <label for="email" class="control-label sr-only">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') ?: Auth::user() ? Auth::user()->email : '' }}" class="form-control @error('email') is-invalid @enderror" required>
                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
            </div>       
            <div class="form-group col-md-6">
                <label for="name" class="control-label sr-only">Nom</label>
                <input type="text" id="name" name="name" placeholder="Nom de la l'organisme" value="{{ old('name') ?: Auth::user() ? Auth::user()->name : '' }}" class="form-control @error('name') is-invalid @enderror" required>
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="domain" class="control-label sr-only">Domaine</label>
                <select id="domain" name="domain" class="form-control @error('domain') is-invalid @enderror" required>
                    <option value="">Domaine</option>
                    @foreach($domains as $domain)
                        <option value="{{ $domain }}" {{ set_selected($domain, old('domain')) }}>{{ $domain }}</option>
                    @endforeach
                </select>
                {{--<input type="text" id="domain" name="domain" placeholder="Domaine du diplôme" value="{{ old('domain') ?: $training->domain }}" class="form-control @error('domain') is-invalid @enderror" required>--}}
                {!! $errors->first('domain', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6">
                <label for="diploma" class="control-label sr-only">Diplôme</label>
                <input type="text" id="diploma" name="diploma" placeholder="Nom du diplôme" value="{{ old('diploma') ?: $training->diploma }}" class="form-control @error('diploma') is-invalid @enderror" required onchange="auto_complete(this)" onkeyup="auto_complete(this)" list="diplomaname">
                <datalist id="diplomaname">
                    
                </datalist>
                {!! $errors->first('diploma', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="cost" class="control-label sr-only">Coût</label>
                <input type="number" step="0.01" id="cost" name="cost" placeholder="Coût" value="{{ old('cost') ?: $training->cost }}" class="form-control @error('cost') is-invalid @enderror" required>
                {!! $errors->first('cost', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6">
                <label for="date" class="control-label sr-only">Date</label>
                <input type="date" id="date" name="date" placeholder="Date" value="{{ old('date') ?: $training->date }}" class="form-control @error('date') is-invalid @enderror" required>
                {!! $errors->first('date', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="start" class="control-label sr-only">Heure de début</label>
                <input type="time" id="start" name="start" placeholder="Heure de début" value="{{ old('start') ?: $training->start }}" class="form-control @error('start') is-invalid @enderror" required> 
                {!! $errors->first('start', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3">
                <label for="end" class="control-label sr-only">Heure de fin</label>
                <input type="time" id="end" name="end" placeholder="Heure de fin" value="{{ old('end') ?: $training->end }}" class="form-control @error('end') is-invalid @enderror" required> 
                {!! $errors->first('end', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-6">
                <label for="location" class="control-label sr-only">Lieu</label>
                <input type="text" id="location" name="location" placeholder="Lieu" value="{{ old('location') ?: $training->location }}" class="form-control @error('location') is-invalid @enderror" required>
                {!! $errors->first('location', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="Ncoord" class="control-label sr-only">°N</label>
                <input type="number" step="0.00001" id="Ncoord" name="Ncoord" placeholder="°N" value="{{ old('Ncoord') ?: $training->Ncoord }}" class="form-control @error('Ncoord') is-invalid @enderror" required>
                {!! $errors->first('Ncoord', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3">
                <label for="Ecoord" class="control-label sr-only">°E</label>
                <input type="number" step="0.00001" id="Ecoord" name="Ecoord" placeholder="°E" value="{{ old('Ecoord') ?: $training->Ecoord }}" class="form-control @error('Ecoord') is-invalid @enderror" required>
                {!! $errors->first('Ecoord', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3">
                <label for="region" class="control-label sr-only">Région</label>
                <select id="region" name="region" class="form-control @error('region') is-invalid @enderror" required>
                    <option value="">Région</option>
                    @foreach($regions as $region)
                        <option value="{{ $region }}" {{ set_selected($region, old('region')) }}>{{ $region }}</option>
                    @endforeach
                </select>
                {!! $errors->first('region', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group col-md-3">
                <label for="department" class="control-label sr-only">Département</label>
                <select id="department" name="department" class="form-control @error('department') is-invalid @enderror" required>>
                    <option value="">Département</option>
                    @for($i=1; $i <= 19; $i++)
                        <option {{ set_selected($i, old('department')) }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                    <option {{ set_selected(96, old('department')) }} value="96">2A</option>
                    <option {{ set_selected(97, old('department')) }} value="97">2B</option>
                    @for($i=20; $i <= 95; $i++)
                        <option {{ set_selected($i, old('department')) }} {{ set_selected($i, old('department')) }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                {!! $errors->first('department', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="description" class="control-label sr-only">Description</label>
                <textarea name="description" id="description" placeholder="Description de la formation" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') ?: $training->description }}</textarea>
                {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
            </div>      
            <div class="form-group col-md-6">
                <label for="funding" class="control-label sr-only">Financement</label>
                <textarea name="funding" id="funding" placeholder="Financement" class="form-control @error('funding') is-invalid @enderror" required>{{ old('funding') ?: $training->funding }}</textarea>
                {!! $errors->first('funding', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="form-group">
            <label for="prospect" class="control-label sr-only">Perspectives d'avenir</label>
            <textarea name="prospect" id="prospect" placeholder="Perspectives d'avenir" class="form-control @error('prospect') is-invalid @enderror" required>{{ old('prospect') ?: $training->prospect }}</textarea>
            {!! $errors->first('prospect', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {!! captcha_img() !!}
            </div>      
            <div class="form-group col-md-6">
                <input type="text" name="captcha" class="form-control @error('captcha') is-invalid @enderror">
                {!! $errors->first('captcha', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Créer" class="btn btn-primary btn-block">
        </div>
    </form>

    <a href="{{ route('trainings.index') }}">Toutes les formations</a>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function auto_complete(x) {
        form = document.getElementById('form')
        httpReq = new XMLHttpRequest;
        token = document.querySelector('meta[name="csrf-token"]').content;
        httpReq.open("POST","{{ route('auto_complete') }}",true);
        httpReq.setRequestHeader("Content-Type","application/x-www-form-urlencoded ;charset=utf-8") ;
        httpReq.setRequestHeader('X-CSRF-TOKEN', token);
        httpReq.send("diploma="+x.value);
        httpReq.onreadystatechange = function(){
            if (httpReq.readyState===4 && httpReq.status===200) {
                reponse = httpReq.responseText;
                data = reponse.split('|');
                if (data[0] != "!!!") {
                    form.description.value = data[0]
                    form.funding.value = data[1]
                    form.prospect.value = data[2] 
                }else {
                    list = document.getElementById("diplomaname")
                    list.innerHTML = ""
                    for (var i = 1; i < data.length; i++) {
                        list.innerHTML += '<option value="'+ data[i] +'">'
                    }
                    
                }
            }
                
        }
    }
</script>

@stop