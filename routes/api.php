<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\TermController;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Taxonomy;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function (Request $request) {
});
Route::apiResource('auth', AuthController::class)->only(['store']);
Route::apiResource('home', HomeController::class)->only(['index']);
Route::apiResource('doctors', DoctorController::class)->only(['index', 'show']);
Route::apiResource('hospitals', HospitalController::class)->only('index');
Route::apiResource('doctors', DoctorController::class)->only(['store']);
Route::apiResource('blogs', BlogController::class)->only(['show', 'index']);

Route::group([
    'as' => 'api.',
    //'middleware' => ['auth:api']
], function () {
    Route::delete('auth', [AuthController::class, 'destroy']);
    Route::apiResource('auth', AuthController::class)->except(['store', 'show', 'destroy']);
    Route::apiResource('sliders', SliderController::class)->except(['store', 'destroy']);
    Route::apiResource('slides', SlideController::class)->except(['index']);
    Route::apiResource('terms', TermController::class);
    Route::apiResource('hospitals', HospitalController::class)->except('index');
    Route::apiResource('taxonomies', TaxonomyController::class)->only('index');
    Route::apiResource('blogs', BlogController::class)->except(['show', 'index']);

});
Route::post('import', function (Request $request) {
    // Validate the uploaded file
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    // Get the uploaded file
    $file = $request->file('file');



    // Read the Excel file using Laravel Excel
    $data = Excel::toArray([], $file);

    // Get the first sheet data
    $sheetData = $data[0];
    // Loop through the sheet data and insert into the doctors table
    unset($sheetData[0]);

    foreach ($sheetData as $row) {
        $data = [
            'first_name' => $row[3],
            'last_name' => $row[2],
            'code' => $row[1],
            'sub_title' => $row[5],
            'hospital' => $row[7],
            'term' => $row[4],
        ];
        \App\Jobs\ImportDoctorJob::dispatch($data);
    }

    return response()->json(['message' => 'request queued'], 200);

});
