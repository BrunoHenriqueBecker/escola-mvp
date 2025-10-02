@extends('layout')
@section('content')
<h3>Nova turma</h3>
<form method="POST" action="{{ route('turmas.store') }}" class="row g-3">
  @csrf
  <div class="col-md-6"><label class="form-label">Nome</label><input type="text" name="nome" class="form-control" required></div>
  <div class="col-md-3"><label class="form-label">Ano letivo</label>
    <select name="academic_year_id" class="form-select" required>
      @foreach($years as $y)<option value="{{ $y->id }}">{{ $y->year }}</option>@endforeach
    </select></div>
  <div class="col-md-3"><label class="form-label">Escola</label>
    <select name="school_id" class="form-select" required>
      @foreach($schools as $s)<option value="{{ $s->id }}">{{ $s->nome }}</option>@endforeach
    </select></div>
  <div class="col-12"><button class="btn btn-primary">Salvar</button><a class="btn btn-secondary" href="{{ route('turmas.index') }}">Voltar</a></div>
</form>
@endsection
