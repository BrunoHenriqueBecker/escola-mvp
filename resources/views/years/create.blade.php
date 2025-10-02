@extends('layout')
@section('content')
<h3>Novo ano letivo</h3>
<form method="POST" action="{{ route('years.store') }}" class="row g-3">
  @csrf
  <div class="col-md-6"><label class="form-label">Ano</label><input type="number" name="year" class="form-control" min="2000" max="2100" required></div>
  <div class="col-12"><button class="btn btn-primary">Salvar</button><a class="btn btn-secondary" href="{{ route('years.index') }}">Voltar</a></div>
</form>
@endsection
