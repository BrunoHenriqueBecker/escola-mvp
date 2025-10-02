<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Para o meu amor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
    <a class="navbar-brand" href="{{ route('activities.index') }}">Para o meu amor</a>
    <div class="navbar-nav">
      <a class="nav-link" href="{{ route('activities.index') }}">Atividades</a>
      <a class="nav-link" href="{{ route('subjects.index') }}">Assuntos</a>
      <a class="nav-link" href="{{ route('turmas.index') }}">Turmas</a>
      <a class="nav-link" href="{{ route('years.index') }}">Anos</a>
      <a class="nav-link" href="{{ route('schools.index') }}">Escolas</a>
      <a class="nav-link" href="{{ route('reports.subject_timeline') }}">Relatórios</a>
    </div>
    @auth
      <span class="navbar-text ms-auto">Olá, {{ auth()->user()->name }}</span>
    @endauth
  </div>
</nav>
<div class="container">
  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif
  {{ $slot ?? '' }}
  @yield('content')
</div>
</body>
</html>