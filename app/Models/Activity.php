<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Activity extends Model {
    use HasFactory;
    protected $fillable = ['titulo','tipo','data','descricao','turma_id'];
    protected $casts = ['data'=>'date'];
    public function turma(){ return $this->belongsTo(Turma::class); }
    public function subjects(){ return $this->belongsToMany(Subject::class); }
    public function attachments(){ return $this->hasMany(Attachment::class); }

    public function scopeFilter(Builder $q, array $filters): Builder {
        return $q
            ->when($filters['tipo'] ?? null, fn($qq,$tipo)=>$qq->where('tipo',$tipo))
            ->when($filters['subject_id'] ?? null, function($qq,$sid){ $qq->whereHas('subjects', fn($w)=>$w->where('subjects.id',$sid)); })
            ->when($filters['year'] ?? null, function($qq,$year){ $qq->whereHas('turma.year', fn($w)=>$w->where('academic_years.year',$year)); })
            ->when($filters['turma_id'] ?? null, fn($qq,$tid)=>$qq->where('turma_id',$tid))
            ->when($filters['school_id'] ?? null, function($qq,$sid){ $qq->whereHas('turma.school', fn($w)=>$w->where('schools.id',$sid)); });
    }
}