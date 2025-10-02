@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Atividades</h3>
  <a href="{{ route('activities.create') }}" class="btn btn-primary">Nova atividade</a>
</div>

<form method="GET" class="row g-2 mb-3">
  <div class="col-md-2">
    <label class="form-label">Tipo</label>
    <select class="form-select" name="tipo">
      <option value="">Todos</option>
      @foreach(['prova'=>'Prova','trabalho'=>'Trabalho','atividade'=>'Atividade'] as $k=>$v)
        <option value="{{ $k }}" @selected(($filters['tipo'] ?? '')==$k)>{{ $v }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Assunto</label>
    <select class="form-select" name="subject_id">
      <option value="">Todos</option>
      @foreach($subjects as $s)
        <option value="{{ $s->id }}" @selected(($filters['subject_id'] ?? '')==$s->id)>{{ $s->nome }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2">
    <label class="form-label">Ano</label>
    <select class="form-select" name="year">
      <option value="">Todos</option>
      @foreach($years as $y)
        <option value="{{ $y->year }}" @selected(($filters['year'] ?? '')==$y->year)>{{ $y->year }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Escola</label>
    <select class="form-select" name="school_id">
      <option value="">Todas</option>
      @foreach($schools as $sc)
        <option value="{{ $sc->id }}" @selected(($filters['school_id'] ?? '')==$sc->id)>{{ $sc->nome }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2">
    <label class="form-label">Turma</label>
    <select class="form-select" name="turma_id">
      <option value="">Todas</option>
      @foreach($turmas as $t)
        <option value="{{ $t->id }}" @selected(($filters['turma_id'] ?? '')==$t->id)>{{ $t->nome }} ({{ $t->year->year }}) - {{ $t->school->nome }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-12 d-flex gap-2">
    <button class="btn btn-outline-primary" type="submit">Filtrar</button>
    <a class="btn btn-outline-secondary" href="{{ route('activities.index') }}">Limpar</a>
    <a class="btn btn-success ms-auto" href="{{ route('activities.export', array_merge(request()->query(), ['format'=>'xlsx'])) }}">Exportar Excel</a>
    <a class="btn btn-outline-success" href="{{ route('activities.export', array_merge(request()->query(), ['format'=>'csv'])) }}">Exportar CSV</a>
  </div>
</form>

<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th>Título</th><th>Tipo</th><th>Data</th><th>Turma</th><th>Escola</th><th>Assuntos</th><th>Anexos</th><th style="width:230px">Ações</th>
    </tr>
  </thead>
  <tbody>
    @forelse($activities as $a)
      <tr>
        <td>{{ $a->titulo }}</td>
        <td><span class="badge bg-dark text-capitalize">{{ $a->tipo }}</span></td>
        <td>{{ optional($a->data)->format('d/m/Y') }}</td>
        <td>{{ $a->turma->nome }} ({{ $a->turma->year->year }})</td>
        <td>{{ $a->turma->school->nome ?? '' }}</td>
        <td>@foreach($a->subjects as $s)<span class="badge bg-secondary">{{ $s->nome }}</span>@endforeach</td>
        <td>@foreach($a->attachments as $att)<a href="{{ asset('storage/'.$att->path) }}" target="_blank" class="badge bg-info text-dark text-decoration-none">Arquivo</a>@endforeach</td>
        <td>
          <a class="btn btn-sm btn-outline-primary" href="{{ route('activities.edit',$a) }}">Editar</a>
          <form method="POST" action="{{ route('activities.destroy',$a) }}" class="d-inline">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover?')">Del</button>
          </form>
          <form method="POST" action="{{ route('activities.duplicate',$a) }}" class="d-inline">@csrf
            <button class="btn btn-sm btn-outline-secondary">Duplicar</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="8" class="text-muted">Nenhuma atividade encontrada.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $activities->links() }}
@endsection
