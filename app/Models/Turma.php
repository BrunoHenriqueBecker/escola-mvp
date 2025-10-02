<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model {
    use HasFactory;
    protected $fillable = ['nome','academic_year_id','school_id'];
    public function year(){ return $this->belongsTo(AcademicYear::class,'academic_year_id'); }
    public function school(){ return $this->belongsTo(School::class); }
    public function activities(){ return $this->hasMany(Activity::class); }
}