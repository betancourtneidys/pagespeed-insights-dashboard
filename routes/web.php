<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta para mostrar el formulario inicial donde el usuario puede elegir las opciones para generar las métricas.
Route::get('/', [MetricsController::class, 'showForm'])->name('metricsForm');

// Ruta para realizar la llamada a la API de Google PageSpeed Insights y obtener las métricas de una página.
Route::get('/get-page-speed-metrics', [MetricsController::class, 'getPageSpeedMetrics']);

// Ruta para mostrar el historial de ejecuciones de métricas guardadas.
Route::get('/metric-history', [MetricsController::class, 'showHistory'])->name('metrics.history');

// Ruta para guardar una ejecución de métricas en la base de datos.
Route::post('/save-metric-run', [MetricsController::class, 'store']);
