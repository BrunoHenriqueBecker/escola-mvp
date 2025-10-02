@extends('layout')
@section('content')
<h3>Relatório: Linha do Tempo por Assunto</h3>
<form method="GET" class="row g-2 mb-3">
  <div class="col-md-4"><label class="form-label">Assunto</label>
    <select class="form-select" name="subject_id">
      <option value="">Todos</option>
      @foreach($subjects as $s)<option value="{{ $s->id }}" @selected(($subjectId ?? null)==$s->id)>{{ $s->nome }}</option>@endforeach
    </select>
  </div>
  <div class="col-md-2"><label class="form-label">Ano letivo</label><input type="number" class="form-control" name="year" value="{{ $year }}" placeholder="Ex.: 2024"></div>
  <div class="col-md-3"><label class="form-label">Escola</label>
    <select class="form-select" name="school_id">
      <option value="">Todas</option>
      @foreach($schools as $sc)<option value="{{ $sc->id }}" @selected(($schoolId ?? null)==$sc->id)>{{ $sc->nome }}</option>@endforeach
    </select>
  </div>
  <div class="col-12 d-flex gap-2">
    <button class="btn btn-outline-primary" type="submit">Filtrar</button>
    <a class="btn btn-outline-secondary" href="{{ route('reports.subject_timeline') }}">Limpar</a>
    <a class="btn btn-outline-dark ms-auto" href="{{ route('reports.subject_timeline_pdf', request()->query()) }}">Exportar PDF</a>
  </div>
</form>
@if($rows && count($rows))
  @foreach($rows as $subjectName => $byYear)
    @php $turmas = $byYear['_turmas'] ?? []; unset($byYear['_turmas']); @endphp
    <div class="card mb-4">
      <div class="card-header fw-semibold">{{ $subjectName }}</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead><tr><th style="width:220px">Ano</th><th>Provas</th><th>Trabalhos</th><th>Atividades</th><th>Total</th><th>Turmas</th></tr></thead>
            <tbody>
              @foreach($allYears as $yy)
                @if(isset($byYear[$yy]))
                  <tr>
                    <td>{{ $yy }}</td>
                    <td>{{ $byYear[$yy]['prova'] ?? 0 }}</td>
                    <td>{{ $byYear[$yy]['trabalho'] ?? 0 }}</td>
                    <td>{{ $byYear[$yy]['atividade'] ?? 0 }}</td>
                    <td><strong>{{ $byYear[$yy]['total'] ?? 0 }}</strong></td>
                    <td>@if(isset($turmas[$yy])) @foreach(array_keys($turmas[$yy]) as $tn)<span class="badge bg-secondary me-1">{{ $tn }}</span>@endforeach @endif</td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endforeach
@else
  <p class="text-muted">Nenhum dado para exibir com os filtros atuais.</p>
@endif
@endsection
