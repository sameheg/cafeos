<?php

use Illuminate\Support\Facades\Route;
use Modules\FloorPlanDesigner\Http\Controllers\FloorplanController;

Route::patch('/{floorplan}', [FloorplanController::class, 'update'])
    ->middleware('throttle:5,1')
    ->name('update');

Route::get('/heatmap/{floorplan}', [FloorplanController::class, 'heatmap'])
    ->name('heatmap');


use Modules\FloorPlanDesigner\Http\Controllers\ZoneController;
use Modules\FloorPlanDesigner\Http\Controllers\ActionsController;
use Modules\FloorPlanDesigner\Http\Controllers\ExportImportController;

Route::get('/{floorplan}/zones', [ZoneController::class, 'index'])->name('zones.index');
Route::post('/{floorplan}/zones', [ZoneController::class, 'store'])->name('zones.store');
Route::patch('/{floorplan}/zones/{zone}', [ZoneController::class, 'update'])->name('zones.update');
Route::delete('/{floorplan}/zones/{zone}', [ZoneController::class, 'destroy'])->name('zones.destroy');

Route::post('/{floorplan}/publish', [ActionsController::class, 'publish'])->name('publish');
Route::post('/{floorplan}/archive', [ActionsController::class, 'archive'])->name('archive');
Route::post('/{floorplan}/schedule', [ActionsController::class, 'schedule'])->name('schedule');

Route::get('/export/{floorplan}', [ExportImportController::class, 'export'])->name('export');
Route::post('/import', [ExportImportController::class, 'import'])->name('import');


/**
 * ASSET delivery for pro-canvas (adjust to your asset pipeline if needed)
 */
Route::get('/assets/pro-canvas.js', function () {
    $path = module_path('FloorPlanDesigner', '/resources/assets/pro/pro-canvas.js');
    return response()->file($path, ['Content-Type' => 'application/javascript']);
})->name('assets.projs');


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\FloorPlanDesigner\Models\Floorplan;

/**
 * Expose tables from a floorplan (integration point with POS)
 */
Route::get('/{floorplan}/tables', function (Floorplan $floorplan): JsonResponse {
    $furn = collect($floorplan->json_data['furniture'] ?? [])
        ->where('type','table')
        ->map(fn($t) => [
            'furniture_id' => $t['id'] ?? null,
            'name' => $t['meta']['name'] ?? 'Table',
            'capacity' => $t['meta']['cap'] ?? 2,
            'status' => $t['meta']['status'] ?? 'available',
            'pos_table_id' => $t['meta']['pos_table_id'] ?? null,
        ])->values();
    return response()->json(['tables' => $furn]);
})->name('tables.index');


use Modules\FloorPlanDesigner\Http\Controllers\Enterprise\FurnitureController as EntFurniture;

Route::get('/{floorplan}/furniture', [EntFurniture::class,'index'])->name('furniture.index');
Route::post('/{floorplan}/furniture', [EntFurniture::class,'store'])->name('furniture.store');
Route::patch('/{floorplan}/furniture/{furniture}', [EntFurniture::class,'update'])->name('furniture.update');
Route::delete('/{floorplan}/furniture/{furniture}', [EntFurniture::class,'destroy'])->name('furniture.destroy');
Route::post('/{floorplan}/furniture/batch', [EntFurniture::class,'batchSave'])->name('furniture.batch');


/**
 * Enterprise+ overlay: return furniture with live-ready fields (status, name, pos_table_id, qr_url)
 */
Route::get('/{floorplan}/overlay', function(\Modules\FloorPlanDesigner\Models\Floorplan $floorplan){
    $items = \Modules\FloorPlanDesigner\Models\Furniture::where('plan_id',$floorplan->id)->orderBy('layer')->get()->map(function($f){
        return [
            'id'=>(string)$f->id,'type'=>$f->type,'x'=>$f->x,'y'=>$f->y,'w'=>$f->w,'h'=>$f->h,'r'=>$f->r,'layer'=>$f->layer,
            'name'=>$f->name,'capacity'=>$f->capacity,'status'=>$f->status,'pos_table_id'=>$f->pos_table_id,'qr_url'=>$f->qr_url,
        ];
    });
    return response()->json(['data'=>$items]);
})->name('overlay');
