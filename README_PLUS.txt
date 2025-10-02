INSTRUÇÕES - ESCOLA MVP PLUS

1) Criar projeto Laravel e copiar arquivos deste zip por cima.
   composer create-project laravel/laravel escola-mvp

2) Instalar pacotes:
   # Exportação Excel/CSV
   composer require maatwebsite/excel
   # PDF de relatórios
   composer require barryvdh/laravel-dompdf

3) Autenticação com Breeze (opcional, mas recomendado):
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   php artisan migrate
   npm install && npm run build

4) Migrations/seeders do MVP Plus:
   php artisan migrate
   php artisan db:seed --class=DemoSeeder

5) Ativar storage público para anexos:
   php artisan storage:link

6) Rodar servidor:
   php artisan serve

Rotas protegidas por auth (após Breeze):
- CRUD: activities, subjects, turmas, years, schools
- Duplicar atividade: POST /activities/{activity}/duplicate
- Exportar atividades: GET /activities/export?format=xlsx|csv (+ filtros)
- Relatório assunto: GET /reports/subject-timeline (+ PDF em /reports/subject-timeline/pdf)

Filtros disponíveis nas listas/relatório:
- tipo, subject_id, year, turma_id, school_id

Observação:
- A duplicação copia metadados e referências. Para copiar fisicamente os anexos, edite ActivityController@duplicate e use Storage::copy.
