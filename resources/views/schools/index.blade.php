@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Escolas</h3>
  <a href="{{ route('schools.create') }}" class="btn btn-primary">Nova escola</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Nome</th><th style="width:160px">Ações</th></tr></thead>
  <tbody>
    @foreach($schools as $s)
    <tr>
      <td>{{ $s->nome }}</td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('schools.edit',$s) }}">Editar</a>
        <form method="POST" action="{{ route('schools.destroy',$s) }}" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover?')">Del</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $schools->links() }}
@endsection
