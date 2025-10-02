@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Turmas</h3>
  <a href="{{ route('turmas.create') }}" class="btn btn-primary">Nova turma</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Nome</th><th>Ano</th><th>Escola</th><th style="width:160px">Ações</th></tr></thead>
  <tbody>
    @foreach($turmas as $t)
    <tr>
      <td>{{ $t->nome }}</td>
      <td>{{ $t->year->year }}</td>
      <td>{{ $t->school->nome }}</td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('turmas.edit',$t) }}">Editar</a>
        <form method="POST" action="{{ route('turmas.destroy',$t) }}" class="d-inline">@csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover?')">Del</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $turmas->links() }}
@endsection
