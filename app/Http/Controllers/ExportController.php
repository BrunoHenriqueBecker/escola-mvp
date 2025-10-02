<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Exports\ActivitiesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller {
    public function activities(Request $request){
        $filters=$request->only(['tipo','subject_id','year','turma_id','school_id']);
        $format=$request->get('format','xlsx');
        $file='atividades_'.now()->format('Ymd_His').'.'.$format;
        return Excel::download(new ActivitiesExport($filters), $file, $format==='csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX);
    }
}