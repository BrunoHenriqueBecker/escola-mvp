<?php
namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller {
    public function index(){ $subjects=Subject::orderBy('nome')->paginate(15); return view('subjects.index',compact('subjects')); }
    public function create(){ return view('subjects.create'); }
    public function store(Request $r){ $data=$r->validate(['nome'=>'required|string|max:255|unique:subjects,nome']); Subject::create($data); return redirect()->route('subjects.index')->with('ok','Assunto criado.');}
    public function edit(Subject $subject){ return view('subjects.edit',compact('subject')); }
    public function update(Request $r, Subject $subject){ $data=$r->validate(['nome'=>'required|string|max:255|unique:subjects,nome,'.$subject->id]); $subject->update($data); return redirect()->route('subjects.index')->with('ok','Assunto atualizado.'); }
    public function destroy(Subject $subject){ $subject->delete(); return back()->with('ok','Assunto removido.'); }
}