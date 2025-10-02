<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model {
    use HasFactory;
    protected $fillable = ['nome'];
    public function turmas(){ return $this->hasMany(Turma::class); }
}