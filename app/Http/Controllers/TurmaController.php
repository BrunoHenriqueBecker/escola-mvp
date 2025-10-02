<?php
namespace App\Http\Controllers;
use App\Models\{Turma, AcademicYear, School};
use Illuminate\Http\Request;

class TurmaController extends Controller {
    public function index(){ $turmas=Turma::with(['year','school'])->orderBy('nome')->paginate(15); return view('turmas.index',compact('turmas')); }
    public function create(){ $years=AcademicYear::orderByDesc('year')->get(); $schools=School::orderBy('nome')->get(); return view('turmas.create',compact('years','schools')); }
    public function store(Request $r){
        $data=$r->validate(['nome'=>'required','academic_year_id'=>'required|exists:academic_years,id','school_id'=>'required|exists:schools,id']);
        Turma::create($data); return redirect()->route('turmas.index')->with('ok','Turma criada.');
    }
    public function edit(Turma $turma){ $years=AcademicYear::orderByDesc('year')->get(); $schools=School::orderBy('nome')->get(); return view('turmas.edit',compact('turma','years','schools')); }
    public function update(Request $r, Turma $turma){
        $data=$r->validate(['nome'=>'required','academic_year_id'=>'required|exists:academic_years,id','school_id'=>'required|exists:schools,id']);
        $turma->update($data); return redirect()->route('turmas.index')->with('ok','Turma atualizada.');
    }
    public function destroy(Turma $turma){ $turma->delete(); return back()->with('ok','Turma removida.'); }
}