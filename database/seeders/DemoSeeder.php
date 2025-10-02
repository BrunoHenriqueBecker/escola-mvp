<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{AcademicYear, Turma, Subject, Activity, School};

class DemoSeeder extends Seeder {
    public function run(): void {
        $school1 = School::firstOrCreate(['nome'=>'Escola Central']);
        $school2 = School::firstOrCreate(['nome'=>'Colégio Horizonte']);

        $y2024 = AcademicYear::firstOrCreate(['year'=>2024]);
        $y2025 = AcademicYear::firstOrCreate(['year'=>2025]);

        $t1 = Turma::firstOrCreate(['nome'=>'6º A','academic_year_id'=>$y2024->id,'school_id'=>$school1->id]);
        $t2 = Turma::firstOrCreate(['nome'=>'7º B','academic_year_id'=>$y2025->id,'school_id'=>$school2->id]);

        $s1 = Subject::firstOrCreate(['nome'=>'Revolução Francesa']);
        $s2 = Subject::firstOrCreate(['nome'=>'Guerra Fria']);
        $s3 = Subject::firstOrCreate(['nome'=>'Equações do 2º Grau']);

        $a1 = Activity::create(['titulo'=>'Prova Bimestral 1','tipo'=>'prova','data'=>'2025-03-15','descricao'=>'Prova objetiva e discursiva','turma_id'=>$t2->id]);
        $a1->subjects()->sync([$s1->id]);

        $a2 = Activity::create(['titulo'=>'Trabalho em Dupla','tipo'=>'trabalho','data'=>'2024-09-10','descricao'=>'Apresentação sobre a Guerra Fria','turma_id'=>$t1->id]);
        $a2->subjects()->sync([$s2->id]);

        $a3 = Activity::create(['titulo'=>'Lista de Exercícios 02','tipo'=>'atividade','data'=>'2025-04-05','descricao'=>'Resolução de equações quadráticas','turma_id'=>$t2->id]);
        $a3->subjects()->sync([$s3->id]);
    }
}