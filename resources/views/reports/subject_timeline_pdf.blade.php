<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
    h2 { margin: 0 0 10px 0; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #444; padding: 6px; text-align: left; }
    th { background: #efefef; }
    .badge { display: inline-block; background: #ddd; padding: 2px 6px; margin: 1px; border-radius: 4px; }
  </style>
</head>
<body>
<h2>Relatório: Linha do Tempo por Assunto</h2>
@foreach($rows as $subjectName => $byYear)
  <h3>{{ $subjectName }}</h3>
  <table>
    <thead><tr><th>Ano</th><th>Provas</th><th>Trabalhos</th><th>Atividades</th><th>Total</th></tr></thead>
    <tbody>
      @foreach($allYears as $yy)
        @if(isset($byYear[$yy]))
          <tr>
            <td>{{ $yy }}</td>
            <td>{{ $byYear[$yy]['prova'] ?? 0 }}</td>
            <td>{{ $byYear[$yy]['trabalho'] ?? 0 }}</td>
            <td>{{ $byYear[$yy]['atividade'] ?? 0 }}</td>
            <td><strong>{{ $byYear[$yy]['total'] ?? 0 }}</strong></td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>
@endforeach
</body>
</html>
