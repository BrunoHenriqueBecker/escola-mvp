<?php
namespace App\Http\Controllers;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller {
    public function index(){ $years=AcademicYear::orderByDesc('year')->paginate(15); return view('years.index',compact('years')); }
    public function create(){ return view('years.create'); }
    public function store(Request $r){ $data=$r->validate(['year'=>'required|integer|min:2000|max:2100|unique:academic_years,year']); AcademicYear::create($data); return redirect()->route('years.index')->with('ok','Ano criado.'); }
    public function edit(AcademicYear $year){ return view('years.edit',compact('year')); }
    public function update(Request $r, AcademicYear $year){ $data=$r->validate(['year'=>'required|integer|min:2000|max:2100|unique:academic_years,year,'.$year->id]); $year->update($data); return redirect()->route('years.index')->with('ok','Ano atualizado.'); }
    public function destroy(AcademicYear $year){ $year->delete(); return back()->with('ok','Ano removido.'); }
}