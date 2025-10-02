<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Subject, Activity, School};
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller {
    public function subjectTimeline(Request $request){
        $subjectId=$request->get('subject_id');
        $year=$request->get('year');
        $schoolId=$request->get('school_id');

        $subjects=Subject::orderBy('nome')->get();
        $schools=School::orderBy('nome')->get();

        $query=Activity::query()
            ->with(['turma.year','turma.school','subjects'])
            ->when($subjectId, fn($q)=>$q->whereHas('subjects', fn($w)=>$w->where('subjects.id',$subjectId)))
            ->when($year, fn($q)=>$q->whereHas('turma.year', fn($w)=>$w->where('academic_years.year',$year)))
            ->when($schoolId, fn($q)=>$q->whereHas('turma.school', fn($w)=>$w->where('schools.id',$schoolId)));

        $rows=$query->get()
            ->groupBy(fn($a)=> optional($a->subjects->firstWhere('id',$subjectId))->id ?? $a->subjects->pluck('id')->sort()->join('-'))
            ->map(function($acts){
                $bySubject=[];
                foreach($acts as $a){
                    foreach($a->subjects as $s){
                        $subj=$s->nome;
                        $yy=$a->turma->year->year;
                        $bySubject[$subj][$yy][$a->tipo]=($bySubject[$subj][$yy][$a->tipo]??0)+1;
                        $bySubject[$subj][$yy]['total']=($bySubject[$subj][$yy]['total']??0)+1;
                        $bySubject[$subj]['_turmas'][$yy][$a->turma->nome.' ('.$a->turma->school->nome.')']=true;
                    }
                }
                return $bySubject;
            })->collapse();

        $allYears=collect($rows)->flatMap(fn($years)=>array_keys(array_filter($years, fn($k)=>$k!=='_turmas', ARRAY_FILTER_USE_KEY)))->unique()->sort()->values();

        return view('reports.subject_timeline', compact('subjects','schools','rows','allYears','subjectId','year','schoolId'));
    }

    public function subjectTimelinePdf(Request $request){
        // reutiliza a mesma lógica de cima
        $subjectId=$request->get('subject_id');
        $year=$request->get('year');
        $schoolId=$request->get('school_id');

        $query=Activity::query()
            ->with(['turma.year','turma.school','subjects'])
            ->when($subjectId, fn($q)=>$q->whereHas('subjects', fn($w)=>$w->where('subjects.id',$subjectId)))
            ->when($year, fn($q)=>$q->whereHas('turma.year', fn($w)=>$w->where('academic_years.year',$year)))
            ->when($schoolId, fn($q)=>$q->whereHas('turma.school', fn($w)=>$w->where('schools.id',$schoolId)));

        $rows=$query->get()
            ->groupBy(fn($a)=> $a->subjects->pluck('nome')->sort()->join(', '))
            ->map(function($acts){
                $bySubject=[];
                foreach($acts as $a){
                    foreach($a->subjects as $s){
                        $subj=$s->nome;
                        $yy=$a->turma->year->year;
                        $bySubject[$subj][$yy]['prova']=($bySubject[$subj][$yy]['prova']??0)+($a->tipo==='prova');
                        $bySubject[$subj][$yy]['trabalho']=($bySubject[$subj][$yy]['trabalho']??0)+($a->tipo==='trabalho');
                        $bySubject[$subj][$yy]['atividade']=($bySubject[$subj][$yy]['atividade']??0)+($a->tipo==='atividade');
                        $bySubject[$subj][$yy]['total']=($bySubject[$subj][$yy]['total']??0)+1;
                    }
                }
                return $bySubject;
            })->collapse();

        $allYears=collect($rows)->flatMap(fn($years)=>array_keys($years))->unique()->sort()->values();

        $pdf = Pdf::loadView('reports.subject_timeline_pdf', [
            'rows'=>$rows,'allYears'=>$allYears,'filters'=>['subject_id'=>$subjectId,'year'=>$year,'school_id'=>$schoolId]
        ]);
        return $pdf->download('relatorio_assunto.pdf');
    }
}