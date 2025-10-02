<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ActivityController, SubjectController, TurmaController,
    AcademicYearController, SchoolController, ExportController, ReportController
};

Route::get('/', fn () => redirect()->route('activities.index'));

// PROTEGE tudo por auth (precisa do Breeze instalado e logado)
Route::middleware(['auth'])->group(function () {
    Route::resources([
        'activities' => ActivityController::class,
        'subjects'   => SubjectController::class,
        'turmas'     => TurmaController::class,
        'years'      => AcademicYearController::class,
        'schools'    => SchoolController::class, // se você copiou a versão com Escola
    ]);

    Route::post('/activities/{activity}/duplicate', [ActivityController::class,'duplicate'])->name('activities.duplicate');
    Route::delete('/attachments/{attachment}', [ActivityController::class,'destroyAttachment'])->name('attachments.destroy');

    Route::get('/activities/export', [ExportController::class,'activities'])->name('activities.export');

    Route::get('/reports/subject-timeline', [ReportController::class,'subjectTimeline'])->name('reports.subject_timeline');
    Route::get('/reports/subject-timeline/pdf', [ReportController::class,'subjectTimelinePdf'])->name('reports.subject_timeline_pdf');
});

// só requer auth.php se ele existir (Breeze instalado)
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}
