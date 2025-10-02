@extends('layout')
@section('content')
<h3>Nova atividade</h3>
<form method="POST" action="{{ route('activities.store') }}" class="row g-3" enctype="multipart/form-data">
  @csrf
  <div class="col-md-6"><label class="form-label">Título</label><input type="text" name="titulo" class="form-control" required></div>
  <div class="col-md-3"><label class="form-label">Tipo</label>
    <select name="tipo" class="form-select" required>
      <option value="prova">Prova</option><option value="trabalho">Trabalho</option><option value="atividade">Atividade</option>
    </select></div>
  <div class="col-md-3"><label class="form-label">Data</label><input type="date" name="data" class="form-control"></div>
  <div class="col-md-6"><label class="form-label">Turma</label>
    <select name="turma_id" class="form-select" required>
      @foreach($turmas as $t)
        <option value="{{ $t->id }}">{{ $t->nome }} ({{ $t->year->year }}) - {{ $t->school->nome }}</option>
      @endforeach
    </select></div>
  <div class="col-md-6"><label class="form-label">Assuntos (segure CTRL para múltiplos)</label>
    <select name="subjects[]" class="form-select" multiple>
      @foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->nome }}</option>@endforeach
    </select></div>
  <div class="col-12"><label class="form-label">Descrição</label><textarea name="descricao" class="form-control" rows="3"></textarea></div>
  <div class="col-12"><label class="form-label">Anexos</label><input type="file" name="files[]" class="form-control" multiple><div class="form-text">PDF, DOCX, imagens… até 10MB cada.</div></div>
  <div class="col-12"><button class="btn btn-primary">Salvar</button><a class="btn btn-secondary" href="{{ route('activities.index') }}">Voltar</a></div>
</form>
@endsection
