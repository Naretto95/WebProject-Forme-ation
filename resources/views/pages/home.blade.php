@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="container">
    <h1>Rechercher une formation</h1>

    <form id="form" action="{{ route('home.search') }}" method="POST" novalidate="" autocomplete="off">
        @csrf 
        <div class="input-group">
                {{--<input type="text" id="domain" name="domain" placeholder="Domaine" value="{{ old('domain') }}" class="form-control @error('domain') is-invalid @enderror" required>--}}
                <select id="domain" name="domain" class="form-control @error('domain') is-invalid @enderror" required>
                    <option value="">Domaine</option>
                    @foreach($domains as $domain)
                        <option value="{{ $domain }}" {{ set_selected($domain, old('domain')) }}>{{ $domain }}</option>
                    @endforeach
                </select>

                <input type="text" id="diploma" name="diploma" placeholder="Diplôme" value="{{ old('diploma') }}" class="form-control @error('diploma') is-invalid @enderror" required onkeyup="auto_complete(this)" list="diplomaname">
                <datalist id="diplomaname">
                    
                </datalist>
                <select id="region" name="region" class="form-control @error('region') is-invalid @enderror" required>
                    <option value="">Région</option>
                    @foreach($regions as $region)
                        <option value="{{ $region }}" {{ set_selected($region, old('region')) }}>{{ $region }}</option>
                    @endforeach
                </select>
                
                <select id="department" name="department" class="form-control @error('department') is-invalid @enderror" required>>
                    <option value="">Département</option>
                    @for($i=1; $i <= 19; $i++)
                        <option {{ set_selected($i, old('department')) }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                    <option {{ set_selected(96, old('department')) }} value="96">2A</option>
                    <option {{ set_selected(97, old('department')) }} value="97">2B</option>
                    @for($i=20; $i <= 95; $i++)
                        <option {{ set_selected($i, old('department')) }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                
            <div class="input-group-append">
                <input type="submit" value="Rechercher" class="btn btn-danger">
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function auto_complete(x) {
        form = document.getElementById('form')
        httpReq = new XMLHttpRequest;
        token = document.querySelector('meta[name="csrf-token"]').content;
        httpReq.open("POST","{{ route('auto_completebis') }}",true);
        httpReq.setRequestHeader("Content-Type","application/x-www-form-urlencoded ;charset=utf-8") ;
        httpReq.setRequestHeader('X-CSRF-TOKEN', token);
        httpReq.send("diploma="+x.value+"&domain="+form.domain.value);
        httpReq.onreadystatechange = function(){
            if (httpReq.readyState===4 && httpReq.status===200) {
                reponse = httpReq.responseText;
                data = reponse.split('|');                
                list = document.getElementById("diplomaname")
                list.innerHTML = ""
                for (var i = 0; i < data.length; i++) {
                    list.innerHTML += '<option value="'+ data[i] +'">'
                }  
                
            }
                
        }
    }
</script>