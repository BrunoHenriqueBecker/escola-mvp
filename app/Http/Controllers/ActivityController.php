<?php
namespace App\Http\Controllers;

use App\Models\{Activity, Subject, Turma, AcademicYear, Attachment, School};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['tipo','subject_id','year','turma_id','school_id']);
        $activities = Activity::with(['turma.year','turma.school','subjects','attachments'])
            ->filter($filters)->latest('data')->paginate(10)->withQueryString();

        return view('activities.index', [
            'activities'=>$activities,
            'subjects'=>Subject::orderBy('nome')->get(),
            'years'=>AcademicYear::orderByDesc('year')->get(),
            'turmas'=>Turma::with(['year','school'])->orderBy('nome')->get(),
            'schools'=>School::orderBy('nome')->get(),
            'filters'=>$filters
        ]);
    }

    public function create()
    {
        return view('activities.create', [
            'subjects'=>Subject::orderBy('nome')->get(),
            'turmas'=>Turma::with(['year','school'])->orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'=>'required|string|max:255',
            'tipo'=>'required|in:prova,trabalho,atividade',
            'data'=>'nullable|date',
            'descricao'=>'nullable|string',
            'turma_id'=>'required|exists:turmas,id',
            'subjects'=>'array',
            'subjects.*'=>'exists:subjects,id',
            'files'=>'array',
            'files.*'=>'file|max:10240'
        ]);

        $activity = Activity::create(collect($data)->except('subjects','files')->toArray());
        $activity->subjects()->sync($data['subjects'] ?? []);

        if($request->hasFile('files')){
            foreach($request->file('files') as $file){
                if(!$file) continue;
                $path=$file->store('attachments','public');
                $activity->attachments()->create([
                    'original_name'=>$file->getClientOriginalName(),
                    'path'=>$path,'size'=>$file->getSize(),'mime'=>$file->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('activities.index')->with('ok','Atividade criada.');
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit',[
            'activity'=>$activity->load('subjects','turma.year','turma.school','attachments'),
            'subjects'=>Subject::orderBy('nome')->get(),
            'turmas'=>Turma::with(['year','school'])->orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'titulo'=>'required|string|max:255',
            'tipo'=>'required|in:prova,trabalho,atividade',
            'data'=>'nullable|date',
            'descricao'=>'nullable|string',
            'turma_id'=>'required|exists:turmas,id',
            'subjects'=>'array',
            'subjects.*'=>'exists:subjects,id',
            'files'=>'array',
            'files.*'=>'file|max:10240'
        ]);

        $activity->update(collect($data)->except('subjects','files')->toArray());
        $activity->subjects()->sync($data['subjects'] ?? []);

        if($request->hasFile('files')){
            foreach($request->file('files') as $file){
                if(!$file) continue;
                $path=$file->store('attachments','public');
                $activity->attachments()->create([
                    'original_name'=>$file->getClientOriginalName(),
                    'path'=>$path,'size'=>$file->getSize(),'mime'=>$file->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('activities.index')->with('ok','Atividade atualizada.');
    }

    public function destroy(Activity $activity)
    {
        foreach($activity->attachments as $att){
            Storage::disk('public')->delete($att->path);
            $att->delete();
        }
        $activity->delete();
        return back()->with('ok','Atividade removida.');
    }

    public function destroyAttachment(Attachment $attachment){
        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();
        return back()->with('ok','Anexo removido.');
    }

    public function duplicate(Activity $activity)
    {
        $copy = $activity->replicate(['data']);
        $copy->titulo = $activity->titulo.' (Cópia)';
        $copy->data = null;
        $copy->push();

        // same turma
        $copy->turma()->associate($activity->turma);
        $copy->save();

        // relations
        $copy->subjects()->sync($activity->subjects->pluck('id')->toArray());
        foreach($activity->attachments as $att){
            // não copiamos o arquivo físico para economizar espaço; se quiser copiar, descomente abaixo
            // $newPath = 'attachments/'.uniqid().'_'.basename($att->path);
            // Storage::disk('public')->copy($att->path, $newPath);
            $copy->attachments()->create([
                'original_name'=>$att->original_name,
                'path'=>$att->path, // ou $newPath
                'size'=>$att->size,
                'mime'=>$att->mime,
            ]);
        }

        return back()->with('ok','Atividade duplicada.');
    }
}