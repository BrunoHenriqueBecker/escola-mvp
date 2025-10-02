<?php
namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivitiesExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private array $filters = []){}

    public function collection(){
        return Activity::with(['turma.year','turma.school','subjects'])
            ->filter($this->filters)
            ->orderByDesc('data')->get();
    }

    public function headings(): array { return ['Título','Tipo','Data','Turma','Ano','Escola','Assuntos']; }

    public function map($a): array {
        return [
            $a->titulo,
            $a->tipo,
            optional($a->data)->format('d/m/Y'),
            $a->turma->nome,
            $a->turma->year->year,
            $a->turma->school->nome ?? '',
            $a->subjects->pluck('nome')->join(', '),
        ];
    }
}