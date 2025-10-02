@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Anos letivos</h3>
  <a href="{{ route('years.create') }}" class="btn btn-primary">Novo ano</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Ano</th><th style="width:160px">Ações</th></tr></thead>
  <tbody>
    @foreach($years as $y)
    <tr>
      <td>{{ $y->year }}</td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('years.edit',$y) }}">Editar</a>
        <form method="POST" action="{{ route('years.destroy',$y) }}" class="d-inline">@csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover?')">Del</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $years->links() }}
@endsection
