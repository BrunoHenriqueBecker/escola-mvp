<?php
namespace App\Http\Controllers;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller {
    public function index(){ $schools=School::orderBy('nome')->paginate(15); return view('schools.index',compact('schools')); }
    public function create(){ return view('schools.create'); }
    public function store(Request $r){ $data=$r->validate(['nome'=>'required|string|max:255|unique:schools,nome']); School::create($data); return redirect()->route('schools.index')->with('ok','Escola criada.'); }
    public function edit(School $school){ return view('schools.edit',compact('school')); }
    public function update(Request $r, School $school){ $data=$r->validate(['nome'=>'required|string|max:255|unique:schools,nome,'.$school->id]); $school->update($data); return redirect()->route('schools.index')->with('ok','Escola atualizada.'); }
    public function destroy(School $school){ $school->delete(); return back()->with('ok','Escola removida.'); }
}