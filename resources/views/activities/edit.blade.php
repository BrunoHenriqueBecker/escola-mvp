@extends('layout')
@section('content')
<h3>Editar atividade</h3>
<form method="POST" action="{{ route('activities.update',$activity) }}" class="row g-3" enctype="multipart/form-data">
  @csrf @method('PUT')
  <div class="col-md-6"><label class="form-label">Título</label><input type="text" name="titulo" value="{{ old('titulo',$activity->titulo) }}" class="form-control" required></div>
  <div class="col-md-3"><label class="form-label">Tipo</label>
    <select name="tipo" class="form-select" required>
      @foreach(['prova','trabalho','atividade'] as $opt)
        <option value="{{ $opt }}" @selected($activity->tipo==$opt)>{{ ucfirst($opt) }}</option>
      @endforeach
    </select></div>
  <div class="col-md-3"><label class="form-label">Data</label><input type="date" name="data" value="{{ optional($activity->data)->format('Y-m-d') }}" class="form-control"></div>
  <div class="col-md-6"><label class="form-label">Turma</label>
    <select name="turma_id" class="form-select" required>
      @foreach($turmas as $t)
        <option value="{{ $t->id }}" @selected($activity->turma_id==$t->id)>{{ $t->nome }} ({{ $t->year->year }}) - {{ $t->school->nome }}</option>
      @endforeach
    </select></div>
  <div class="col-md-6"><label class="form-label">Assuntos</label>
    <select name="subjects[]" class="form-select" multiple>
      @foreach($subjects as $s)<option value="{{ $s->id }}" @selected($activity->subjects->pluck('id')->contains($s->id))>{{ $s->nome }}</option>@endforeach
    </select></div>
  <div class="col-12"><label class="form-label">Descrição</label><textarea name="descricao" class="form-control" rows="3">{{ old('descricao',$activity->descricao) }}</textarea></div>

  @if($activity->attachments->count())
  <div class="col-12">
    <label class="form-label">Anexos já enviados</label>
    <ul class="list-group">@foreach($activity->attachments as $att)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ asset('storage/'.$att->path) }}" target="_blank">{{ $att->original_name }}</a>
        <form method="POST" action="{{ route('attachments.destroy',$att) }}">@csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover anexo?')">Remover</button>
        </form>
      </li>@endforeach
    </ul>
  </div>
  @endif

  <div class="col-12"><label class="form-label">Adicionar novos anexos</label><input type="file" name="files[]" class="form-control" multiple></div>
  <div class="col-12"><button class="btn btn-primary">Atualizar</button><a class="btn btn-secondary" href="{{ route('activities.index') }}">Voltar</a></div>
</form>
@endsection
