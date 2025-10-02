@extends('layout')
@section('content')
<h3>Nova escola</h3>
<form method="POST" action="{{ route('schools.store') }}" class="row g-3">
  @csrf
  <div class="col-md-6"><label class="form-label">Nome</label><input type="text" name="nome" class="form-control" required></div>
  <div class="col-12"><button class="btn btn-primary">Salvar</button><a class="btn btn-secondary" href="{{ route('schools.index') }}">Voltar</a></div>
</form>
@endsection
