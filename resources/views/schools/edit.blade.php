@extends('layout')
@section('content')
<h3>Editar escola</h3>
<form method="POST" action="{{ route('schools.update',$school) }}" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-6"><label class="form-label">Nome</label><input type="text" name="nome" class="form-control" value="{{ old('nome',$school->nome) }}" required></div>
  <div class="col-12"><button class="btn btn-primary">Atualizar</button><a class="btn btn-secondary" href="{{ route('schools.index') }}">Voltar</a></div>
</form>
@endsection
