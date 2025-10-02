@extends('layout')
@section('content')
<h3>Editar ano letivo</h3>
<form method="POST" action="{{ route('years.update',$year) }}" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-6"><label class="form-label">Ano</label><input type="number" name="year" class="form-control" min="2000" max="2100" value="{{ old('year',$year->year) }}" required></div>
  <div class="col-12"><button class="btn btn-primary">Atualizar</button><a class="btn btn-secondary" href="{{ route('years.index') }}">Voltar</a></div>
</form>
@endsection
