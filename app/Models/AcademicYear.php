<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model {
    use HasFactory;
    protected $fillable = ['year'];
    public function turmas(){ return $this->hasMany(Turma::class); }
}